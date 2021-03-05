<?php

namespace Modules\Updates\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateSuccessfulAlert extends Notification implements ShouldQueue
{
    use Queueable;
    public $installed;
    public $old_version;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($installed, $old_version)
    {
        $this->installed = $installed;
        $this->old_version = $old_version;
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
            ->greeting('Hello ' . $notifiable->name . ',')
            ->subject('Update Successful')
            ->line('Your application has been updated from v.' . $this->old_version . ' to v.' . $this->installed)
            ->line('Check the logs folder for update installation logs')
            ->action('Dashboard Preview', url('/settings/info'))
            ->line('Thank you for using Workice CRM');
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
