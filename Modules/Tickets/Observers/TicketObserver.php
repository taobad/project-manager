<?php

namespace Modules\Tickets\Observers;

use App\Entities\Status;
use Modules\Tickets\Entities\Ticket;
use Modules\Tickets\Jobs\AnswerBot;

class TicketObserver
{

    /**
     * Listen to the Ticket created event.
     *
     * @param Ticket $ticket
     */
    public function creating(Ticket $ticket)
    {
        $ticket->token = genToken();
        $ticket->code = generateCode('tickets');
        $ticket->due_date = now()->addDays(get_option('ticket_due_after'));
        if (!empty($ticket->status) && !is_numeric($ticket->status)) {
            $ticket->status = Status::firstOrCreate(['status' => $ticket->status], ['color' => '#c7254e'])->id;
        }
    }

    /**
     * Listen to the Ticket saving event.
     *
     * @param Ticket $ticket
     */
    public function saving(Ticket $ticket)
    {
        $ticket->user_id = $ticket->user_id > 0 ? $ticket->user_id : request('user_id');
    }

    /**
     * Listen to the Ticket saved event.
     *
     * @param Ticket $ticket
     */
    public function saved(Ticket $ticket)
    {
        if (request()->has('tags')) {
            $ticket->retag(collect(request('tags'))->implode(','));
        }
        $ticket->saveCustom(request('custom'));
        $ticket->afterModelSaved();
    }

    /**
     * Listen to the Ticket created event.
     *
     * @param Ticket $ticket
     */
    public function created(Ticket $ticket)
    {
        settingEnabled('answerbot_active') ? AnswerBot::dispatch($ticket) : '';
    }

    /**
     * Listen to the Ticket deleting event.
     *
     * @param Ticket $ticket
     */
    public function deleting(Ticket $ticket)
    {
        foreach ($ticket->comments as $comment) {
            $comment->delete();
        }
        foreach ($ticket->activities as $activity) {
            $activity->delete();
        }
        foreach ($ticket->files as $file) {
            $file->delete();
        }
        foreach ($ticket->custom as $field) {
            $field->delete();
        }
        foreach ($ticket->vault as $vault) {
            $vault->delete();
        }
        foreach ($ticket->todos as $todo) {
            $todo->delete();
        }
        $ticket->reviews()->delete();
        $ticket->detag();
    }

    /**
     * Listen to the Project deleted event.
     *
     * @param Ticket $ticket
     */
    public function deleted(Ticket $ticket)
    {
        \Artisan::call('analytics:tickets');
    }
}
