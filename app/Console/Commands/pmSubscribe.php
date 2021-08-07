<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Log;
use Illuminate\Support\Str;


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
            Log::alert("This is for PM");
            Log::alert($userData);
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
