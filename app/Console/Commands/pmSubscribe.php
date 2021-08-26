<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Users\Http\Controllers\Api\v1\UsersApiController;
use Log;


class pmSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pm:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'subscribe to a channel from eco project';

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
          Redis::subscribe(['pm-user-registration'], function ($message) {
            $userData  = json_decode($message, true);
            $request = new Request($userData);
            $uapi = new UsersApiController($request);
            $uapi->saveUms($request);
        });
    }
}
