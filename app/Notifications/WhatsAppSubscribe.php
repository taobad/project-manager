<?php

namespace App\Notifications;

use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WhatsAppSubscribe extends Notification
{
    use Queueable;

    public $recipient;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['whatsapp'];
    }

    public function toWhatsapp($notifiable)
    {
        return WhatsappMessage::create()
            ->to($this->recipient)
            ->message(langapp('whatsapp_subscribe_reply', [
                'company' => get_option('company_name'), 'subtext' => get_option('whatsapp_sub_text'),
            ]));
    }
}
