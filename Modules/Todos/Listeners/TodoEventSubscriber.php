<?php

namespace Modules\Todos\Listeners;

class TodoEventSubscriber
{
    protected $user;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = \Auth::id() ?? 1;
    }

    /**
     * Take action when todo is created
     */
    public function onTodoCreated($event)
    {
        $data = [
            'action' => 'activity_create_todo', 'icon'  => 'fa-check-circle-o', 'user_id' => $this->user,
            'value1' => $event->todo->subject, 'value2' => '',
            'url'    => $event->todo->todoable->url,
        ];
        $event->todo->activities()->create($data);
    }

    /**
     * Action taken when todo is updated
     */
    public function onTodoUpdated($event)
    {
        $data = [
            'action' => 'activity_update_todo', 'icon'  => 'fa-pencil-alt', 'user_id' => $this->user,
            'value1' => $event->todo->subject, 'value2' => '',
            'url'    => $event->todo->todoable->url,
        ];
        $event->todo->activities()->create($data);
    }

    /**
     * Action taken when todo is deleted
     */
    public function onTodoDeleted($event)
    {
        $data = [
            'action' => 'activity_delete_todo', 'icon'  => 'fa-trash-alt', 'user_id' => $this->user,
            'value1' => $event->todo->subject, 'value2' => '',
            'url'    => $event->todo->todoable->url,
        ];
        $event->todo->activities()->create($data);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Modules\Todos\Events\TodoCreated',
            'Modules\Todos\Listeners\TodoEventSubscriber@onTodoCreated'
        );

        $events->listen(
            'Modules\Todos\Events\TodoUpdated',
            'Modules\Todos\Listeners\TodoEventSubscriber@onTodoUpdated'
        );
        $events->listen(
            'Modules\Todos\Events\TodoDeleted',
            'Modules\Todos\Listeners\TodoEventSubscriber@onTodoDeleted'
        );
    }
}
