<?php

namespace Modules\Deals\Notifications;

use App\Channels\ShoutoutMessage;
use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Deals\Entities\Deal;
use NotificationChannels\AwsPinpoint\AwsPinpointSmsMessage;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioSmsMessage;

class DealCreatedAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $deal;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
        $this->type = 'deal_created';
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
                ->from(get_option('company_email'), get_option('company_name'))
                ->subject(langmail('deals.created.subject', ['title' => $this->deal->title]))
                ->greeting(langmail('deals.created.greeting', ['name' => $notifiable->name]))
                ->line(
                    langmail(
                        'deals.created.body',
                        [
                            'title' => $this->deal->title,
                            'pipeline' => $this->deal->pipe->name,
                            'stage' => $this->deal->category->name,
                            'source' => $this->deal->AsSource->name,
                            'deal_value' => $this->deal->computed_value,
                        ]
                    )
                )
                ->action('View Deal', route('deals.view', $this->deal->id));
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        if ($notifiable->channelActive('slack', $this->type)) {
            return (new SlackMessage())
                ->success()
                ->content(langmail(
                    'deals.created.body',
                    [
                        'title' => $this->deal->title,
                        'pipeline' => $this->deal->pipe->name,
                        'stage' => $this->deal->category->name,
                        'source' => $this->deal->AsSource->name,
                        'deal_value' => $this->deal->computed_value,
                    ]
                ))
                ->attachment(
                    function ($attachment) {
                        $attachment->title($this->deal->title, route('deals.view', $this->deal->id))
                            ->fields(
                                [
                                    langapp('company') => $this->deal->company->name,
                                    langapp('pipeline') => $this->deal->pipe->name,
                                    langapp('stage') => $this->deal->category->name,
                                    langapp('deal_value') => $this->deal->computed_value,
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
                'subject' => langmail('deals.created.subject', ['title' => $this->deal->title]),
                'icon' => 'plus-circle',
                'activity' => langmail(
                    'deals.created.body',
                    [
                        'title' => $this->deal->title,
                        'pipeline' => $this->deal->pipe->name,
                        'stage' => $this->deal->category->name,
                        'source' => $this->deal->AsSource->name,
                        'deal_value' => $this->deal->computed_value,
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
                ->content(langmail(
                    'deals.created.body',
                    [
                        'title' => $this->deal->title,
                        'pipeline' => $this->deal->pipe->name,
                        'stage' => $this->deal->category->name,
                        'source' => $this->deal->AsSource->name,
                        'deal_value' => $this->deal->computed_value,
                    ]
                ));
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
                ->custom($this->deal->id)
                ->message(langmail(
                    'deals.created.body',
                    [
                        'title' => $this->deal->title,
                        'pipeline' => $this->deal->pipe->name,
                        'stage' => $this->deal->category->name,
                        'source' => $this->deal->AsSource->name,
                        'deal_value' => $this->deal->computed_value,
                    ]
                ));
        }
    }
    /**
     * Send message via Twilio
     */
    public function toTwilio($notifiable)
    {
        if ($notifiable->channelActive('sms', $this->type)) {
            return (new TwilioSmsMessage())
                ->content(langmail(
                    'deals.created.body',
                    [
                        'title' => $this->deal->title,
                        'pipeline' => $this->deal->pipe->name,
                        'stage' => $this->deal->category->name,
                        'source' => $this->deal->AsSource->name,
                        'deal_value' => $this->deal->computed_value,
                    ]
                ));
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
                langmail('deals.created.body', [
                    'title' => $this->deal->title,
                    'pipeline' => $this->deal->pipe->name,
                    'stage' => $this->deal->category->name,
                    'source' => $this->deal->AsSource->name,
                    'deal_value' => $this->deal->computed_value,
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
                    langmail('deals.created.body', [
                        'title' => $this->deal->title,
                        'pipeline' => $this->deal->pipe->name,
                        'stage' => $this->deal->category->name,
                        'source' => $this->deal->AsSource->name,
                        'deal_value' => $this->deal->computed_value,
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
                    langmail('deals.created.body', [
                        'title' => $this->deal->title,
                        'pipeline' => $this->deal->pipe->name,
                        'stage' => $this->deal->category->name,
                        'source' => $this->deal->AsSource->name,
                        'deal_value' => $this->deal->computed_value,
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
                    langmail('deals.created.body', [
                        'title' => $this->deal->title,
                        'pipeline' => $this->deal->pipe->name,
                        'stage' => $this->deal->category->name,
                        'source' => $this->deal->AsSource->name,
                        'deal_value' => $this->deal->computed_value,
                    ])
                )
                ->button('View Deal', route('deals.view', [$this->deal->id]));
        }
    }
}
