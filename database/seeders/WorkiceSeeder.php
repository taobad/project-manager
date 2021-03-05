<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Clients\Entities\Client;
use Modules\Comments\Entities\Comment;
use Modules\Contracts\Entities\Contract;
use Modules\Creditnotes\Entities\CreditNote;
use Modules\Deals\Entities\Deal;
use Modules\Estimates\Entities\Estimate;
use Modules\Expenses\Entities\Expense;
use Modules\Invoices\Entities\Invoice;
use Modules\Items\Entities\Item;
use Modules\Knowledgebase\Entities\Knowledgebase;
use Modules\Leads\Entities\Lead;
use Modules\Milestones\Entities\Milestone;
use Modules\Payments\Entities\Payment;
use Modules\Projects\Entities\Project;
use Modules\Tasks\Entities\Task;
use Modules\Teams\Entities\Assignment;
use Modules\Tickets\Entities\Ticket;
use Modules\Users\Entities\User;

class WorkiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->times(20)->create();
        Client::factory()->times(20)->create();
        Deal::factory()->times(80)->create();
        Lead::factory()->times(80)->create();
        Contract::factory()->times(10)->create();
        Invoice::factory()->times(20)
            ->has(Item::factory()->count(2))
            ->has(Payment::factory()->count(1))
            ->create();
        Estimate::factory()->times(20)
            ->has(Item::factory()->count(2))
            ->create();
        CreditNote::factory()->times(10)
            ->has(Item::factory()->count(2))
            ->create();
        Project::factory()->times(50)
            ->has(Assignment::factory()->count(rand(1, 4)), 'assignees')
            ->has(Task::factory()->times(10)->has(Assignment::factory()->count(rand(1, 2)), 'assignees'))
            ->has(Milestone::factory()->count(3))
            ->has(Comment::factory()->count(rand(1, 3)))
            ->create();
        Expense::factory()->times(20)
            ->has(Comment::factory()->count(2))
            ->create();
        Ticket::factory()->times(50)
            ->has(Comment::factory()->count(2))
            ->create();
        Knowledgebase::factory()->times(20)
            ->has(Comment::factory()->count(2))
            ->create();
    }
}
