<?php

namespace Modules\Timetracking\Observers;

use Modules\Timetracking\Entities\TimeEntry;

class TimerObserver
{
    /**
     * Listen to the Timer saving event.
     *
     * @param TimeEntry $entry
     */
    public function saving(TimeEntry $entry)
    {
        $entry->total = request()->has('total') ? timelog($entry->total) : $entry->total;
    }
    /**
     * Listen to the Timer saving event.
     *
     * @param TimeEntry $entry
     */
    public function saved(TimeEntry $entry)
    {
        $entry->afterModelSaved();
        if ($entry->task_id > 0) {
            $entry->task->afterModelSaved();
        }
        $entry->timeable->afterModelSaved();
    }

    /**
     * Listen to the Timer deleted event.
     *
     * @param TimeEntry $entry
     */
    public function deleted(TimeEntry $entry)
    {
        if ($entry->task_id > 0) {
            $entry->task->afterModelSaved();
        }
        $entry->timeable->afterModelSaved();
    }
}
