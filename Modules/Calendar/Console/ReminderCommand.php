<?php

namespace Modules\Calendar\Console;

use Illuminate\Console\Command;
use Modules\Calendar\Jobs\ReminderAlertJob;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder alerts';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ReminderAlertJob::dispatch();
        $this->info('Reminder alerts sent successfully');
    }
}
