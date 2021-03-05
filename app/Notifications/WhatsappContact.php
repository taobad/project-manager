<?php

namespace App\Notifications;

use App\Entities\Chat;
use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WhatsappContact extends Notification
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
        return ['whatsapp'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toWhatsapp($notifiable)
    {
        return WhatsappMessage::create()
            ->to($this->chat->to)
            ->custom($this->chat->id)
            ->message($this->chat->message);
    }
}
