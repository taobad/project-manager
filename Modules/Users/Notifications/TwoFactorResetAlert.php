<?php

namespace Modules\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorResetAlert extends Notification
{
    use Queueable;
    public $secret;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(get_option('company_email'), get_option('company_name'))
            ->greeting('Hello ' . $notifiable->name . ',')
            ->subject(get_option('company_name') . ' Two Factor Reset')
            ->line('Enter this code ' . $this->secret . ' into your Google Authenticator App to get 2FA unlock code.')
            ->line('Thank you for using our portal!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
