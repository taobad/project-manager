<?php

namespace Modules\Projects\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Projects\Entities\Project;
use Modules\Users\Entities\QuickAccess;

class ProjectObserver
{

    /**
     * Listen to Project creating event.
     *
     * @param Project $project
     */
    public function creating(Project $project)
    {
        $project->code = generateCode('projects');
        if (!request()->filled('settings')) {
            $project->settings = json_decode(get_option('default_project_settings'));
        }
        if (is_null($project->token)) {
            $project->token = genToken();
        }
    }
    /**
     * Listen to Project saving event.
     *
     * @param Project $project
     */
    public function saving(Project $project)
    {
        if (is_null($project->token)) {
            $project->token = genToken();
        }
    }

    /**
     * Listen to Project saved event.
     *
     * @param Project $project
     */
    public function saved(Project $project)
    {
        if (request()->has('tags')) {
            $project->retag(collect(request('tags'))->implode(','));
        }
        $project->saveCustom(request('custom'));
        $project->assignTeam(request('team'));
        $project->afterModelSaved();
        Cache::forget('quick-access-' . Auth::id());
    }

    /**
     * Listen to Project deleting event.
     *
     * @param Project $project
     */
    public function deleting(Project $project)
    {
        foreach ($project->tasks as $task) {
            $task->delete();
        }
        foreach ($project->milestones as $milestone) {
            $milestone->delete();
        }
        foreach ($project->issues as $issue) {
            $issue->delete();
        }

        foreach ($project->comments as $comment) {
            $comment->delete();
        }
        foreach ($project->expenses as $expense) {
            $expense->delete();
        }
        foreach ($project->invoices as $invoice) {
            $invoice->delete();
        }
        foreach ($project->files as $file) {
            $file->delete();
        }
        foreach ($project->links as $link) {
            $link->delete();
        }
        foreach ($project->tickets as $ticket) {
            $ticket->delete();
        }
        foreach ($project->schedules as $event) {
            $event->delete();
        }
        foreach ($project->todos as $todo) {
            $todo->delete();
        }
        foreach ($project->timesheets as $entry) {
            $entry->delete();
        }
        foreach ($project->activities as $activity) {
            $activity->delete();
        }
        foreach ($project->assignees as $member) {
            $member->delete();
        }
        $project->detag();
        QuickAccess::where('project_id', $project->id)->delete();
        Cache::forget('quick-access-' . Auth::id());
    }

    /**
     * Listen to the Project deleted event.
     *
     * @param Project $project
     */
    public function deleted(Project $project)
    {
        \Artisan::call('analytics:projects');
    }
}
