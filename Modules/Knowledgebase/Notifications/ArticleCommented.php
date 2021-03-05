<?php

namespace Modules\Knowledgebase\Notifications;

use App\Channels\ShoutoutMessage;
use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Knowledgebase\Entities\Knowledgebase;
use NotificationChannels\AwsPinpoint\AwsPinpointSmsMessage;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ArticleCommented extends Notification implements ShouldQueue
{
    use Queueable;

    public $article;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Knowledgebase $article)
    {
        $this->article = $article;
        $this->type = 'article_commented';
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
                ->subject(langmail('knowledgebase.commented.subject', ['subject' => $this->article->subject]))
                ->greeting(langmail('knowledgebase.commented.greeting', ['name' => $notifiable->name]))
                ->line(
                    langmail('knowledgebase.commented.body', [
                        'subject' => $this->article->subject,
                    ])
                )
                ->action('View Comment', route('kb.view', $this->article->id));
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
                    langmail('knowledgebase.commented.body', [
                        'subject' => $this->article->subject,
                    ])
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
                'subject' => langmail('knowledgebase.commented.subject', ['subject' => $this->article->subject]),
                'icon' => 'comments',
                'activity' => langmail('knowledgebase.commented.body', [
                    'subject' => $this->article->subject,
                ]),
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
                    langmail('knowledgebase.commented.body', [
                        'subject' => $this->article->subject,
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
                ->custom($this->article->id)
                ->message(
                    langmail('knowledgebase.commented.body', [
                        'subject' => $this->article->subject,
                    ])
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
                    langmail('knowledgebase.commented.body', [
                        'subject' => $this->article->subject,
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
                langmail('knowledgebase.commented.body', [
                    'subject' => $this->article->subject,
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
                    langmail('knowledgebase.commented.body', [
                        'subject' => $this->article->subject,
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
                    langmail('knowledgebase.commented.body', [
                        'subject' => $this->article->subject,
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
                    langmail('knowledgebase.commented.body', [
                        'subject' => $this->article->subject,
                    ])
                )
                ->button('View Comment', route('kb.view', $this->article->id));
        }
    }
}
