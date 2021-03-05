<?php

namespace Modules\Tickets\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Tickets\Entities\Ticket;

class TicketClosedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $ticket;
    public $recipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, $recipient)
    {
        $this->ticket = $ticket;
        $this->recipient = $recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(supportEmail()['email'], supportEmail()['name'])
            ->subject(langmail('tickets.closed.subject', ['code' => $this->ticket->code, 'subject' => $this->ticket->subject]))
            ->markdown('emails.tickets.closed');
    }
}
