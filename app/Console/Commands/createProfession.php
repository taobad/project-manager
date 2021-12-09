<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Log;
use App\Http\Controllers\ProfessionController;

class createProfession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pm:create-profession';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     *
     * @return int
     */
    public function handle()
    {
        Redis::subscribe(['pm-add-profession'], function ($data) {
            $profession  = json_decode($data, true);
            $newprof = new ProfessionController();
            $newprof->create($profession);
        });
    }
}
