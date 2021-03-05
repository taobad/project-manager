<?php

namespace Modules\Estimates\Notifications;

use App\Channels\ShoutoutMessage;
use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Estimates\Entities\Estimate;
use NotificationChannels\AwsPinpoint\AwsPinpointSmsMessage;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioSmsMessage;

class EstimateAcceptedAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $estimate;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Estimate $estimate)
    {
        $this->estimate = $estimate;
        $this->type = 'estimate_accepted_alert';
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
            return $notifiable->notifyOn($this->type, ['mail', 'slack']);
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
                ->greeting(langmail('estimates.accepted.greeting', ['name' => $notifiable->name]))
                ->subject(langmail('estimates.accepted.subject'))
                ->line(
                    langmail(
                        'estimates.accepted.body',
                        [
                            'code' => $this->estimate->reference_no,
                            'client' => $this->estimate->company->name,
                            'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
                        ]
                    )
                )
                ->action('View Estimate', route('estimates.view', $this->estimate->id));
        }
    }

    /*
    Send slack notification
     */
    public function toSlack($notifiable)
    {
        if ($notifiable->channelActive('slack', $this->type)) {
            return (new SlackMessage())
                ->success()
                ->content(
                    langmail(
                        'estimates.accepted.body',
                        [
                            'code' => $this->estimate->reference_no,
                            'client' => $this->estimate->company->name,
                            'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
                        ]
                    )
                )
                ->attachment(
                    function ($attachment) {
                        $attachment->title($this->estimate->reference_no, route('estimates.view', $this->estimate->id))
                            ->fields(
                                [
                                    langapp('title') => $this->estimate->name,
                                    langapp('amount') => formatCurrency($this->estimate->currency, $this->estimate->amount),
                                    langapp('company') => $this->estimate->company->name,
                                    langapp('status') => $this->estimate->status,
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
                'subject' => langmail('estimates.accepted.subject'),
                'icon' => 'check-circle',
                'activity' => langmail(
                    'estimates.accepted.body',
                    [
                        'code' => $this->estimate->reference_no,
                        'client' => $this->estimate->company->name,
                        'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
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
                        'estimates.accepted.body',
                        [
                            'code' => $this->estimate->reference_no,
                            'client' => $this->estimate->company->name,
                            'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
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
                ->custom($this->estimate->id)
                ->message(
                    langmail(
                        'estimates.accepted.body',
                        [
                            'code' => $this->estimate->reference_no,
                            'client' => $this->estimate->company->name,
                            'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
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
                    langmail('estimates.accepted.body', [
                        'code' => $this->estimate->reference_no,
                        'client' => $this->estimate->company->name,
                        'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
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
                langmail('estimates.accepted.body', [
                    'code' => $this->estimate->reference_no,
                    'client' => $this->estimate->company->name,
                    'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
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
                    langmail('estimates.accepted.body', [
                        'code' => $this->estimate->reference_no,
                        'client' => $this->estimate->company->name,
                        'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
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
                    langmail('estimates.accepted.body', [
                        'code' => $this->estimate->reference_no,
                        'client' => $this->estimate->company->name,
                        'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
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
                    langmail('estimates.accepted.body', [
                        'code' => $this->estimate->reference_no,
                        'client' => $this->estimate->company->name,
                        'amount' => formatCurrency($this->estimate->currency, $this->estimate->amount),
                    ])
                )
                ->button('View Estimate', route('estimates.view', [$this->estimate->id]));
        }
    }
}
