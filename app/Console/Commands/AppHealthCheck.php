<?php

namespace App\Console\Commands;

use App\Entities\Category;
use Illuminate\Console\Command;
use Modules\Activity\Entities\Activity;
use Modules\Clients\Entities\Client;
use Modules\Contracts\Entities\Contract;
use Modules\Deals\Entities\Deal;
use Modules\Expenses\Entities\Expense;
use Modules\Invoices\Entities\Invoice;
use Modules\Projects\Entities\Project;
use Modules\Tasks\Entities\Task;
use Modules\Teams\Entities\Assignment;
use Modules\Tickets\Entities\Ticket;
use Modules\Users\Entities\Profile;
use Modules\Users\Entities\User;

class AppHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:health';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan database for potential orphan records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // TODO complete checks
        $this->checkOrpanRecords();
        $this->info('Application health checked successfully');
    }

    protected function checkOrpanRecords()
    {
        $this->invoicesWithoutClient();
        $this->expensesWithoutProject();
        $this->clientsWithoutContact();
        $this->dealsWithoutContact();
        $this->contactWithoutClient();
        $this->usersWithoutProfile();
        $this->profileWithoutUsers();
        $this->contractsWithoutClients();
        $this->activitiesWithoutUsers();
        $this->assignmentsWithoutAccounts();
        $this->ticketsWithoutReporter();
        $this->tasksWithoutProjects();
        $this->tasksWithoutCategories();
    }

    protected function invoicesWithoutClient()
    {
        foreach (Invoice::select(['id', 'client_id', 'reference_no'])->whereNull('archived_at')->get() as $invoice) {
            if (Client::select('id')->whereId($invoice->client_id)->count() === 0) {
                $invoice->delete();
                $this->info($invoice->reference_no . ' has been removed');
            }
        }
    }
    protected function contactWithoutClient()
    {
        foreach (Profile::select(['id', 'user_id', 'company'])->where('company', '>', 0)->get() as $profile) {
            if (Client::select('id')->where('id', $profile->company)->count() === 0) {
                $profile->update(['company' => 0]);
                $this->info('User ID ' . $profile->id . ' company has been fixed');
            }
        }
    }

    protected function usersWithoutProfile()
    {
        foreach (User::select(['id', 'name'])->get() as $user) {
            if (Profile::select('id', 'user_id', 'avatar', 'use_gravatar')->where('user_id', $user->id)->count() === 0) {
                $user->delete();
                $this->info($user->name . ' has no profile and deleted');
            }
        }
    }

    protected function contractsWithoutClients()
    {
        foreach (Contract::select(['id', 'client_id', 'contract_title'])->get() as $contract) {
            if (Client::select('id')->where('id', $contract->client_id)->count() === 0) {
                $contract->delete();
                $this->info($contract->contract_title . ' has no client attached and deleted');
            }
        }
    }

    protected function profileWithoutUsers()
    {
        foreach (Profile::select(['id', 'user_id', 'use_gravatar', 'avatar'])->get() as $info) {
            if (User::select('id', 'email', 'name')->where('id', $info->user_id)->count() == 0) {
                $info->delete();
                $this->info('User ID ' . $info->user_id . ' has no user and deleted');
            }
        }
    }

    protected function expensesWithoutProject()
    {
        foreach (Expense::select(['project_id', 'code', 'client_id'])->where('project_id', '>', 0)->get() as $expense) {
            if (Project::select('id')->whereId($expense->project_id)->count() === 0) {
                $expense->unsetEventDispatcher();
                $expense->update(['project_id' => 0]);
                $this->info($expense->code . ' is attached to a missing project ID ' . $expense->project_id);
            }
        }
    }

    protected function tasksWithoutProjects()
    {
        foreach (Task::select(['id', 'name', 'project_id'])->where('project_id', '>', 0)->get() as $task) {
            if (Project::select('id')->whereId($task->project_id)->count() === 0) {
                $task->delete();
                $this->info($task->name . ' is attached to a missing project ID ' . $task->project_id);
            }
        }
    }
    protected function tasksWithoutCategories()
    {
        foreach (Task::select(['id', 'name', 'stage_id'])->get() as $task) {
            if (Category::select('id')->where('id', $task->stage_id)->count() === 0) {
                $task->unsetEventDispatcher();
                $task->update(['stage_id' => Category::firstOrCreate(['name' => 'Backlog', 'module' => 'tasks'])->id]);
                $this->info($task->name . ' is attached to a missing category');
            }
        }
    }

    protected function assignmentsWithoutAccounts()
    {
        foreach (Assignment::select(['id', 'user_id', 'assignable_type', 'assignable_id'])->get() as $member) {
            if (User::select('id')->where('id', $member->user_id)->count() === 0) {
                $member->delete();
                $this->info('Team member ' . $member->user_id . ' has no account ');
            }
        }
    }

    protected function clientsWithoutContact()
    {
        foreach (Client::select(['id', 'primary_contact'])->get() as $client) {
            if (User::select('id')->where('id', $client->primary_contact)->count() === 0 && $client->primary_contact > 0) {
                $client->update(['primary_contact' => null]);
                $this->info($client->id . ' is attached to a missing contact');
            }
        }
    }

    protected function dealsWithoutContact()
    {
        foreach (Deal::select(['id', 'contact_person', 'title'])->get() as $deal) {
            if (User::select('id')->whereId($deal->contact_person)->count() === 0 && $deal->contact_person > 0) {
                $deal->update(['contact_person' => null]);
                $this->info($deal->title . ' is attached to a missing contact');
            }
        }
    }

    protected function ticketsWithoutReporter()
    {
        foreach (Ticket::select(['id', 'user_id', 'subject'])->get() as $ticket) {
            if (User::select('id')->whereId($ticket->user_id)->count() === 0) {
                $ticket->delete();
                $this->info($ticket->subject . ' is attached to a missing reporter');
            }
        }
    }
    protected function activitiesWithoutUsers()
    {
        foreach (Activity::select(['id', 'user_id', 'action'])->get() as $activity) {
            if (User::select('id')->whereId($activity->user_id)->count() === 0) {
                $activity->delete();
                $this->info('Activity ' . $activity->action . ' has been removed');
            }
        }
    }
}
