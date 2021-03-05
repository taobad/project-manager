<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Updates\Jobs\UpdateSystemJob;

class UpdateCommand extends Command
{
    public $installed;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workice:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update your workice app';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        set_time_limit(600); // 1 hour
        $this->info('Checking for update...');
        $this->line('');
        $this->info('Installing updates...');
        UpdateSystemJob::dispatch(firstAdminId());

        $this->info('Successfully updated to the latest available version');
    }
}
