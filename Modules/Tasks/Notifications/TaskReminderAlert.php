<?php

namespace Modules\Tasks\Notifications;

use App\Channels\ShoutoutMessage;
use App\Services\WhatsappMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Tasks\Entities\Task;
use NotificationChannels\AwsPinpoint\AwsPinpointSmsMessage;
use NotificationChannels\Messagebird\MessagebirdMessage;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioSmsMessage;

class TaskReminderAlert extends Notification implements ShouldQueue
{
    use Queueable;
    public $task;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->type = 'task_reminder_alert';
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
            return $notifiable->notifyOn($this->type, ['slack', 'mail']);
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
                ->greeting(langmail('tasks.reminder.greeting', ['name' => $notifiable->name]))
                ->subject(langmail('tasks.reminder.subject'))
                ->line(
                    langmail('tasks.reminder.body', [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
                    ])
                )
                ->action('Complete Task', route('projects.view', ['project' => $this->task->AsProject->id, 'tab' => 'tasks', 'item' => $this->task->id]));
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
                    langmail('tasks.reminder.body', [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
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
                'subject' => langmail('tasks.reminder.subject'),
                'icon' => 'tasks',
                'activity' => langmail(
                    'tasks.reminder.body',
                    [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
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
                    langmail('tasks.reminder.body', [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
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
                ->custom($this->task->id)
                ->message(
                    langmail('tasks.reminder.body', [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
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
                    langmail('tasks.reminder.body', [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
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
                langmail('tasks.reminder.body', [
                    'name' => $this->task->name,
                    'date' => dateTimeFormatted($this->task->due_date),
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
                    langmail('tasks.reminder.body', [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
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
                    langmail('tasks.reminder.body', [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
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
                    langmail('tasks.reminder.body', [
                        'name' => $this->task->name,
                        'date' => dateTimeFormatted($this->task->due_date),
                    ])
                )
                ->button('Complete Task', route('projects.view', ['project' => $this->task->AsProject->id, 'tab' => 'tasks', 'item' => $this->task->id]));
        }
    }
}
