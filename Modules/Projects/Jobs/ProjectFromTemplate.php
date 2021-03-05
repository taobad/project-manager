<?php

namespace Modules\Projects\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Projects\Entities\Project;

class ProjectFromTemplate
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;
    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    public $project;
    public $request;
    public $newProject;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->project = new Project;
        $this->request = $request;
        $this->newProject = [];
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->copyProject();

        if (count($this->request->parts)):
            foreach ($this->request->parts as $key => $value) {
                switch ($key) {
                    case 'expenses':
                        $this->cloneExpenses();
                        break;
                    case 'tasks':
                        $this->cloneTasks();
                        break;
                    case 'milestones':
                        $this->cloneMilestones();
                        break;
                    case 'timesheets':
                        $this->cloneTimesheets();
                        break;
                    case 'tickets':
                        $this->cloneTickets();
                        break;
                    case 'events':
                        $this->cloneEvents();
                        break;
                    case 'comments':
                        $this->cloneComments();
                        break;
                    case 'todo':
                        $this->cloneTodos();
                        break;
                    case 'issues':
                        $this->cloneIssues();
                        break;
                    case 'files':
                        $this->cloneFiles();
                        break;
                    case 'links':
                        $this->cloneLinks();
                        break;
                    default:
                        break;
                }
            }
        return $this->newProject;
        endif;

        return [];
    }

    public function copyProject()
    {
        $this->project = $this->project->findOrFail($this->request->id);
        $this->project->name = $this->request->name;
        $this->project->code = generateCode('projects');
        $this->project->client_id = $this->request->client_id;
        $this->project->is_template = 0;
        $this->newProject = $this->project->replicate();
        $this->newProject->save();

        // clone project members
        foreach ($this->project->assignees as $user) {
            $this->newProject->assignees()->create(['user_id' => $user->user_id]);
        }
        // retag project
        $this->newProject->retag($this->project->tagList);
    }

    public function cloneExpenses()
    {
        foreach ($this->project->expenses as $oldExpense) {
            $expense = $oldExpense->replicate();
            $expense->project_id = $this->newProject->id;
            $expense->save();
            $expense->retag($oldExpense->tagList);
        }
    }

    public function cloneTasks()
    {
        foreach ($this->project->tasks->where('milestone_id', '<=', 0) as $task) {
            $newTask = $task->replicate();
            $newTask->milestone_id = 0;
            $newTask->project_id = $this->newProject->id;
            $newTask->save();
            $newTask->retag($task->tagList);

            foreach ($task->assignees as $user) {
                $newTask->assignees()->create(['user_id' => $user->user_id]);
            }
            foreach ($task->timesheets as $entry) {
                $entry = $entry->replicate();
                $entry->timeable_id = $this->newProject->id;
                $entry->task_id = $newTask->id;
                $entry->save();
            }
        }
    }

    public function cloneMilestones()
    {
        foreach ($this->project->milestones as $milestone) {
            $newMilestone = $milestone->replicate();
            $newMilestone->project_id = $this->newProject->id;
            $newMilestone->save();
            foreach ($milestone->tasks as $phase) {
                $task = $phase->replicate();
                $task->milestone_id = $newMilestone->id;
                $task->project_id = $this->newProject->id;
                $task->save();
                $task->retag($phase->tagList);

                foreach ($phase->assignees as $user) {
                    $task->assignees()->create(['user_id' => $user->user_id]);
                }
                foreach ($phase->timesheets as $ent) {
                    $ent = $ent->replicate();
                    $ent->task_id = $task->id;
                    $ent->timeable_id = $this->newProject->id;
                    $ent->save();
                }
            }
        }
    }

    public function cloneTimesheets()
    {
        foreach ($this->project->timesheets()->whereNull('task_id')->get() as $entry) {
            $entry = $entry->replicate();
            $entry->timeable_id = $this->newProject->id;
            $entry->save();
        }
    }

    public function cloneTickets()
    {
        foreach ($this->project->tickets as $oldTicket) {
            $ticket = $oldTicket->replicate();
            $ticket->code = generateCode('tickets');
            $ticket->project_id = $this->newProject->id;
            $ticket->save();
            $ticket->retag($oldTicket->tagList);
        }
    }

    public function cloneEvents()
    {
        foreach ($this->project->schedules as $event) {
            $event = $event->replicate();
            $event->eventable_id = $this->newProject->id;
            $event->event_name = $this->newProject->name;
            $event->save();
        }
    }

    public function cloneComments()
    {
        foreach ($this->project->comments as $comment) {
            $comment = $comment->replicate();
            $comment->commentable_id = $this->newProject->id;
            $comment->save();
        }
    }

    public function cloneTodos()
    {
        foreach ($this->project->todos as $todo) {
            $todo = $todo->replicate();
            $todo->todoable_id = $this->newProject->id;
            $todo->save();
        }
    }

    public function cloneIssues()
    {
        foreach ($this->project->issues as $oldIssue) {
            $issue = $oldIssue->replicate();
            $issue->code = generateCode('issues');
            $issue->project_id = $this->newProject->id;
            $issue->save();
            $issue->retag($oldIssue->tagList);
        }
    }

    public function cloneFiles()
    {
        foreach ($this->project->files as $file) {
            $file = $file->replicate();
            $file->uploadable_id = $this->newProject->id;
            $file->save();
        }
    }

    public function cloneLinks()
    {
        foreach ($this->project->links as $link) {
            $link = $link->replicate();
            $link->project_id = $this->newProject->id;
            $link->save();
        }
    }
}
