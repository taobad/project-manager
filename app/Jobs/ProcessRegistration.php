<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class ProcessRegistration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //This job publish a message (user registration data) to a channel which UMS service subcribes to
        //Log::info("Job processing");
        // Redis::set('pmToUmsChannel', json_encode([
        //     'name' => 'Mubarak Eneye Moshood',
        //     'email' => 'moshoodmubarak@gmail.com'
        // ]));

        // $test = Redis::get('pmToUmsChannel');
        // //Log::info($test);
        // echo $test;
        Log::info("message published");
        Redis::publish('test-channel', json_encode([
            'name' => 'Mubarak Eneye Moshood',
            'email' => 'moshoodmubarak@gmail.com',
            'profession' => 'Engineer'
        ]));

        Log::info("message published after");
    }
}
