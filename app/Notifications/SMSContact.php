<?php

namespace App\Notifications;

use App\Entities\Chat;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SMSContact extends Notification
{
    use Queueable;

    public $chat;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [get_option('sms_driver', 'twilio')];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content(strip_tags($this->chat->message));
    }
    /**
     * Send message via Twilio
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->statusCallback(route('sms.inbound', get_option('cron_key')))
            ->content(strip_tags($this->chat->message));
    }
}
