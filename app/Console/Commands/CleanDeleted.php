<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class CleanDeleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleaner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to delete soft deleted records';

    protected $day;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->day = now()->subMinutes((int) config('system.delete_after'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tables = $this->tables();
        foreach ($tables as $table) {
            DB::table($table)->whereNotNull('deleted_at')->whereDate('deleted_at', '<', $this->day->toDateTimeString())->delete();
        }
        $this->info('Records deleted successfully');
    }

    private function tables()
    {
        return [
            'activities',
            'comments',
            'contracts',
            'payments',
        ];
    }
}
