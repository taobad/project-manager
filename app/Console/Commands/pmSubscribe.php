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
        Log::info("call pm:subscribe command");
          Redis::subscribe(['pm-user-registration'], function ($message) {
            $userData  = json_decode($message, true);
            $request = new Request($userData);
            $uapi = new UsersApiController($request);
            $uapi->saveUms($request);
            //Log::alert($request);
            // if(Str::contains($userData['requestUrl'], 'seller')){
            //     Log::alert("I WILL CALL THE SELLER REGISTRATION METHOD");
            //     $guestController = new GuestController;
            //     $guestController->sellerRegisterUms($userData);
            // }elseif(Str::contains($userData['requestUrl'], 'professional') || Str::contains($userData['requestUrl'], 'consultant')){
            //     Log::alert("I WILL CALL THE PROFESSIONAL REGISTRATION METHOD");
            //     $consultantController = new ConsultantRegisterController;
            //     $consultantController->registerUms($userData);
            // }elseif(Str::contains($userData['requestUrl'], 'supplier')){
            //     Log::alert("I WILL CALL THE SUPPLIER REGISTRATION METHOD");
            //     $consultantController = new ConsultantRegisterController;
            //     $consultantController->registerUms($userData);
            // }
            
            // else{
            //     // Guest registration goes here
            //     Log::alert("THIS IS JUST A GUEST USER");
            //     $guestController = new GuestController;
            //     $guestController->guestregisterUms($userData);
            // }
            // build a request and pass to the method
        });
    }
}
