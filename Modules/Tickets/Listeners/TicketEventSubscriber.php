<?php

namespace Modules\Tickets\Listeners;

use Auth;
use Modules\Tickets\Notifications\TicketClosedAlert;
use Modules\Tickets\Notifications\TicketCreatedAlert;
use Modules\Tickets\Notifications\TicketOpenedAlert;
use Modules\Tickets\Notifications\TicketStatusAlert;

class TicketEventSubscriber
{
    protected $user;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Auth::check() ? Auth::id() : firstAdminId();
    }

    /**
     * Ticket created listener
     */
    public function onTicketCreated($event)
    {
        $data = [
            'action' => 'activity_create_ticket', 'icon' => 'fa-support', 'user_id' => $this->user,
            'value1' => $event->ticket->subject, 'value2' => $event->ticket->dept->deptname,
            'url' => $event->ticket->url,
        ];
        $event->ticket->activities()->create($data);
        $event->ticket->assign();
        $event->ticket->user->notify(new TicketCreatedAlert($event->ticket));
    }

    /**
     * Ticket updated listener
     */
    public function onTicketUpdated($event)
    {
        $event->ticket->activities()->create([
            'action' => 'activity_update_ticket', 'icon' => 'fa-pencil-alt', 'user_id' => $this->user,
            'value1' => $event->ticket->subject, 'value2' => $event->ticket->dept->deptname,
            'url' => $event->ticket->url,
        ]);
        $event->ticket->user->notify(new TicketStatusAlert($event->ticket));
        $event->ticket->assign();
    }

    /**
     * Ticket deleted listener
     */
    public function onTicketDeleted($event)
    {
        $event->ticket->activities()->create([
            'action' => 'activity_delete_ticket', 'icon' => 'fa-trash-alt', 'user_id' => $this->user,
            'value1' => $event->ticket->subject, 'value2' => '',
            'url' => $event->ticket->url,
        ]);
    }

    /**
     * Ticket closed listener
     */
    public function onTicketClosed($event)
    {
        $event->ticket->activities()->create([
            'action' => 'activity_closed_ticket', 'icon' => 'fa-check-circle', 'user_id' => $this->user,
            'value1' => $event->ticket->subject, 'value2' => now()->toDayDateTimeString(),
            'url' => $event->ticket->url,
        ]);
        $event->ticket->user->notify(new TicketClosedAlert($event->ticket));
    }

    /**
     * Ticket opened listener
     */
    public function onTicketOpened($event)
    {
        $event->ticket->user->notify(new TicketOpenedAlert($event->ticket));
        $event->ticket->agent->notify(new TicketOpenedAlert($event->ticket));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Modules\Tickets\Events\TicketCreated',
            'Modules\Tickets\Listeners\TicketEventSubscriber@onTicketCreated'
        );

        $events->listen(
            'Modules\Tickets\Events\TicketUpdated',
            'Modules\Tickets\Listeners\TicketEventSubscriber@onTicketUpdated'
        );
        $events->listen(
            'Modules\Tickets\Events\TicketDeleted',
            'Modules\Tickets\Listeners\TicketEventSubscriber@onTicketDeleted'
        );
        $events->listen(
            'Modules\Tickets\Events\TicketClosed',
            'Modules\Tickets\Listeners\TicketEventSubscriber@onTicketClosed'
        );
        $events->listen(
            'Modules\Tickets\Events\TicketOpened',
            'Modules\Tickets\Listeners\TicketEventSubscriber@onTicketOpened'
        );
    }
}
