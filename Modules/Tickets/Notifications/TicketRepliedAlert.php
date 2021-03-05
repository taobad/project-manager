<?php

namespace Modules\Tickets\Notifications;

use App\Channels\ShoutoutMessage;
use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Tickets\Emails\TicketRepliedMail;
use Modules\Tickets\Entities\Ticket;
use NotificationChannels\AwsPinpoint\AwsPinpointSmsMessage;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioSmsMessage;

class TicketRepliedAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;
    public $comment;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, $comment)
    {
        $this->ticket = $ticket;
        $this->comment = $comment;
        $this->type = 'ticket_replied_alert';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->notificationActive($this->type)) {
            return $notifiable->notifyOn($this->type, ['slack', 'database', 'mail']);
        }
        return [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return Modules\Tickets\Emails\TicketRepliedMail
     */
    public function toMail($notifiable)
    {
        if ($notifiable->channelActive('mail', $this->type)) {
            return (new TicketRepliedMail($this->ticket, $notifiable->name, $this->comment))->to($notifiable->email);
        }
    }

    public function toSlack($notifiable)
    {
        if ($notifiable->channelActive('slack', $this->type)) {
            return (new SlackMessage())
                ->success()
                ->content(
                    langmail(
                        'tickets.replied.body',
                        [
                            'code' => $this->ticket->code,
                        ]
                    )
                )
                ->attachment(
                    function ($attachment) {
                        $attachment->title($this->ticket->subject, route('tickets.view', $this->ticket->id))
                            ->fields(
                                [
                                    'ID #' => $this->ticket->code,
                                    langapp('reporter') => $this->ticket->user->name,
                                    langapp('department') => $this->ticket->dept->deptname,
                                    langapp('status') => $this->ticket->AsStatus->status,
                                ]
                            );
                    }
                );
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($notifiable->channelActive('database', $this->type)) {
            return [
                'subject' => langmail('tickets.replied.subject', ['code' => $this->ticket->code, 'subject' => $this->ticket->subject]),
                'icon' => 'reply',
                'activity' => langmail('tickets.replied.body', ['code' => $this->ticket->code]),
            ];
        }
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        if ($notifiable->channelActive('sms', $this->type)) {
            return (new NexmoMessage)
                ->content(langmail('tickets.replied.body', [
                    'code' => $this->ticket->code,
                ]));
        }
    }

    /**
     * Send message via WhatsApp
     */
    public function toWhatsapp($notifiable)
    {
        if ($notifiable->channelActive('whatsapp', $this->type)) {
            return WhatsappMessage::create()
                ->to($notifiable->mobile)
                ->custom($this->ticket->id)
                ->message(langmail('tickets.replied.body', ['code' => $this->ticket->code]));
        }
    }
    /**
     * Send message via Twilio
     */
    public function toTwilio($notifiable)
    {
        if ($notifiable->channelActive('sms', $this->type)) {
            return (new TwilioSmsMessage())
                ->content(langmail('tickets.replied.body', ['code' => $this->ticket->code]));
        }
    }

    /**
     * Send SMS via AWS Pinpoint.
     *
     * @param \Modules\Users\Entities\User $notifiable
     * @return \NotificationChannels\AwsPinpoint\AwsPinpointSmsMessage
     */
    public function toAwsPinpoint($notifiable)
    {
        if ($notifiable->channelActive('sms', $this->type)) {
            return (new AwsPinpointSmsMessage(
                langmail('tickets.replied.body', [
                    'code' => $this->ticket->code,
                ])
            ));
        }
    }

    /**
     * Send SMS via Messagebird
     *
     * @param \Modules\Users\Entities\User $notifiable
     * @return NotificationChannels\Messagebird\MessagebirdMessage;
     */

    public function toMessagebird($notifiable)
    {
        if ($notifiable->channelActive('sms', $this->type)) {
            if (!is_null($notifiable->profile->mobile)) {
                return (new MessagebirdMessage(
                    langmail('tickets.replied.body', [
                        'code' => $this->ticket->code,
                    ])
                ));
            }
        } else {
            return (new MessagebirdMessage())->setRecipients([]);
        }
    }
    /**
     * Undocumented function
     *
     * @param [type] $notifiable
     * @return void
     */
    public function toShoutout($notifiable)
    {
        if ($notifiable->channelActive('sms', $this->type)) {
            if (!is_null($notifiable->profile->mobile)) {
                return (new ShoutoutMessage(
                    langmail('tickets.replied.body', [
                        'code' => $this->ticket->code,
                    ])
                ));
            }
        }
    }

    public function toTelegram($notifiable)
    {
        if ($notifiable->channelActive('telegram', $this->type)) {
            return TelegramMessage::create()
                ->content(
                    langmail('tickets.replied.body', [
                        'code' => $this->ticket->code,
                    ])
                )
                ->button('View Ticket', route('tickets.view', [$this->ticket->id]));
        }
    }
}
