<?php

namespace Modules\Calendar\Jobs;

use App\Entities\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Calendar\Notifications\ReminderAlert;

class ReminderAlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;
    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Send reminders for each appointment
     *
     * @return void
     */
    public function handle()
    {
        $alerts = Reminder::reminderAlerts()->get();
        foreach ($alerts as $alert) {
            $alert->recipient->notify(new ReminderAlert($alert));
            $alert->update(['reminded_at' => now()->toDateTimeString()]);
        }
    }
}
