<?php

namespace Modules\Tasks\Observers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Tasks\Entities\Task;
use Modules\Users\Entities\QuickAccess;

class TaskObserver
{

    /**
     * Listen to the Task saving event.
     *
     * @param Task $task
     */
    public function saving(Task $task)
    {
        $task->time = $task->totalTime();
        $task->hourly_rate = $task->hourly_rate > 0 ? $task->hourly_rate : $task->AsProject->hourly_rate;
        if (empty($task->stage_id) || is_null($task->stage_id)) {
            $task->stage_id = \App\Entities\Category::firstOrCreate(['name' => 'Backlog', 'module' => 'tasks'])->id;
        }
    }

    /**
     * Listen to the Task saved event.
     *
     * @param Task $task
     */
    public function saved(Task $task)
    {
        if (request()->has('tags')) {
            $task->retag(collect(request('tags'))->implode(','));
        }
        $task->assignTeam(request('team'));
        $task->afterModelSaved();
        $task->AsProject->afterModelSaved();
        Cache::forget('tasks-today-count-' . Auth::id());
        Cache::forget('quick-access-' . Auth::id());
    }

    /**
     * Listen to Task deleting event.
     *
     * @param Task $task
     */
    public function deleting(Task $task)
    {
        foreach ($task->comments as $comment) {
            $comment->delete();
        }
        foreach ($task->files as $file) {
            $file->delete();
        }
        foreach ($task->timesheets as $entry) {
            $entry->delete();
        }
        foreach ($task->assignees as $team) {
            $team->delete();
        }
        foreach ($task->vault as $vault) {
            $vault->delete();
        }
        foreach ($task->todos as $todo) {
            $todo->delete();
        }
        foreach ($task->schedules as $event) {
            $event->delete();
        }
        $task->recurring()->delete();
        $task->detag();
        QuickAccess::where('task_id', $task->id)->delete();
        Cache::forget('quick-access-' . Auth::id());
    }

    /**
     * Listen to the Task deleted event.
     *
     * @param Task $task
     */
    public function deleted(Task $task)
    {
        Artisan::call('analytics:tasks');
    }
}
