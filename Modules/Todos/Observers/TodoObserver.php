<?php

namespace Modules\Todos\Observers;

use Modules\Todos\Entities\Todo;

class TodoObserver
{

    /**
     * Listen to Todo creating event.
     *
     * @param Todo $todo
     */

    public function creating(Todo $todo)
    {
        if (is_null($todo->user_id)) {
            $todo->user_id = \Auth::id();
        }
        if (is_null($todo->assignee)) {
            $todo->assignee = \Auth::id();
        }
        if (is_null($todo->due_date)) {
            $todo->due_date = now()->addDays(7);
        }
    }

    /**
     * Listen to Todo saving event.
     *
     * @param Todo $todo
     */

    public function saved(Todo $todo)
    {
        if ($todo->todoable->todos->count() > 0) {
            $percent = formatDecimal(($todo->todoable->todos()->done()->count() / $todo->todoable->todos->count()) * 100);
            $todo->todoable->todo_percent = $percent;
            $todo->todoable->updated_at = now();
            $todo->todoable->save();
            if ($todo->todoable instanceof \Modules\Tasks\Entities\Task) {
                $todo->todoable->progress = $percent;
                $todo->todoable->saveQuietly();
            }
        }
        \Cache::forget('todo-today-count-' . \Auth::id());
    }

    /**
     * Listen to Todo deleting event.
     *
     * @param Todo $todo
     */
    public function deleting(Todo $todo)
    {
        $todo->child()->each(
            function ($todo) {
                $todo->delete();
            }
        );
        \Cache::forget('todo-today-count-' . \Auth::id());
    }
}
