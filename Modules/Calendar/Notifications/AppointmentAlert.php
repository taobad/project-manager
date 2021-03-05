<?php

namespace Modules\Calendar\Notifications;

use App\Channels\ShoutoutMessage;
use App\Services\WhatsappMessage;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Calendar\Entities\Appointment;
use NotificationChannels\AwsPinpoint\AwsPinpointSmsMessage;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioSmsMessage;

class AppointmentAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $appointment;
    public $time;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->time = Carbon::parse($this->appointment->start_time, $this->appointment->timezone)->toDayDateTimeString();
        $this->type = 'appointment_alert';
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
                ->subject(langmail('appointments.alert.subject'))
                ->greeting(langmail('appointments.alert.greeting', ['name' => $notifiable->name]))
                ->line(
                    langmail(
                        'appointments.alert.body',
                        [
                            'name' => $this->appointment->name,
                            'time' => $this->time,
                            'venue' => $this->appointment->venue,
                        ]
                    )
                )
                ->action('View Appointment', route('calendar.appointment.public', ['token' => $this->appointment->token]));
        }
    }

    /*
    Send slack notification
     */
    public function toSlack($notifiable)
    {
        if ($notifiable->channelActive('slack', $this->type)) {
            return (new SlackMessage)
                ->content(
                    langmail(
                        'appointments.alert.body',
                        [
                            'name' => $this->appointment->name,
                            'time' => $this->time,
                            'venue' => $this->appointment->venue,
                        ]
                    )
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
                'subject' => langmail('appointments.alert.subject'),
                'icon' => 'handshake',
                'activity' => langmail(
                    'appointments.alert.body',
                    [
                        'name' => $this->appointment->name,
                        'time' => $this->time,
                        'venue' => $this->appointment->venue,
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
                    langmail('appointments.alert.body', [
                        'name' => $this->appointment->name,
                        'time' => $this->time,
                        'venue' => $this->appointment->venue,
                    ])
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
                ->custom($this->appointment->id)
                ->message(
                    langmail(
                        'appointments.alert.body',
                        [
                            'name' => $this->appointment->name,
                            'time' => $this->time,
                            'venue' => $this->appointment->venue,
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
                    langmail(
                        'appointments.alert.body',
                        [
                            'name' => $this->appointment->name,
                            'time' => $this->time,
                            'venue' => $this->appointment->venue,
                        ]
                    )
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
                langmail('appointments.alert.body', [
                    'name' => $this->appointment->name,
                    'time' => $this->time,
                    'venue' => $this->appointment->venue,
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
                    langmail('appointments.alert.body', [
                        'name' => $this->appointment->name,
                        'time' => $this->time,
                        'venue' => $this->appointment->venue,
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
                    langmail('appointments.alert.body', [
                        'name' => $this->appointment->name,
                        'time' => $this->time,
                        'venue' => $this->appointment->venue,
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
                    langmail('appointments.alert.body', [
                        'name' => $this->appointment->name,
                        'time' => $this->time,
                        'venue' => $this->appointment->venue,
                    ])
                )
                ->button('View Appointment', route('calendar.appointments'));
        }
    }
}
