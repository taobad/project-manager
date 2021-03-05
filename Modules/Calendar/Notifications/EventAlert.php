<?php

namespace Modules\Calendar\Notifications;

use App\Channels\ShoutoutMessage;
use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Calendar\Entities\Calendar;
use NotificationChannels\AwsPinpoint\AwsPinpointSmsMessage;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioSmsMessage;

class EventAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Calendar $event)
    {
        $this->event = $event;
        $this->type = 'event_alert';
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
            return $notifiable->notifyOn($this->type, ['slack', 'database']);
        }
        return [];
    }

    public function toSlack($notifiable)
    {
        if ($notifiable->channelActive('slack', $this->type)) {
            $url = $this->event->url;
            return (new SlackMessage)
                ->content(langmail('events.alert.subject'))
                ->attachment(
                    function ($attachment) use ($url) {
                        $attachment->title('Venue: ' . $this->event->location, $url)
                            ->content(
                                langmail(
                                    'events.alert.body',
                                    [
                                        'name' => $this->event->event_name,
                                        'date' => dateTimeFormatted($this->event->start_date),
                                        'venue' => $this->event->location,
                                    ]
                                )
                            )
                            ->markdown(['text']);
                    }
                );
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($notifiable->channelActive('mail', $this->type)) {
            return (new MailMessage)
                ->line(
                    langmail(
                        'events.alert.body',
                        [
                            'name' => $this->event->event_name,
                            'date' => dateTimeFormatted($this->event->start_date),
                            'venue' => $this->event->location,
                        ]
                    )
                )
                ->line($this->event->description);
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
                'subject' => langmail('events.alert.subject'),
                'icon' => 'bell',
                'activity' => langmail(
                    'events.alert.body',
                    [
                        'name' => $this->event->event_name,
                        'date' => dateTimeFormatted($this->event->start_date),
                        'venue' => $this->event->location,
                    ]
                ),
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
                ->content(
                    langmail(
                        'events.alert.body',
                        [
                            'name' => $this->event->event_name,
                            'date' => dateTimeFormatted($this->event->start_date),
                            'venue' => $this->event->location,
                        ]
                    )
                );
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
                ->custom($this->event->id)
                ->message(
                    langmail(
                        'events.alert.body',
                        [
                            'name' => $this->event->event_name,
                            'date' => dateTimeFormatted($this->event->start_date),
                            'venue' => $this->event->location,
                        ]
                    )
                );
        }
    }
    /**
     * Send message via Twilio
     */
    public function toTwilio($notifiable)
    {
        if ($notifiable->channelActive('sms', $this->type)) {
            return (new TwilioSmsMessage())
                ->content(
                    langmail('events.alert.body', [
                        'name' => $this->event->event_name,
                        'date' => dateTimeFormatted($this->event->start_date),
                        'venue' => $this->event->location,
                    ])
                );
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
                langmail('events.alert.body', [
                    'name' => $this->event->event_name,
                    'date' => dateTimeFormatted($this->event->start_date),
                    'venue' => $this->event->location,
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
                    langmail('events.alert.body', [
                        'name' => $this->event->event_name,
                        'date' => dateTimeFormatted($this->event->start_date),
                        'venue' => $this->event->location,
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
                    langmail('events.alert.body', [
                        'name' => $this->event->event_name,
                        'date' => dateTimeFormatted($this->event->start_date),
                        'venue' => $this->event->location,
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
                    langmail('events.alert.body', [
                        'name' => $this->event->event_name,
                        'date' => dateTimeFormatted($this->event->start_date),
                        'venue' => $this->event->location,
                    ])
                );
        }
    }
}
