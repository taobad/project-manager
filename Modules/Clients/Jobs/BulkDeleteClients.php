<?php

namespace Modules\Clients\Jobs;

use App;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Modules\Clients\Entities\Client;

class BulkDeleteClients implements ShouldQueue
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

    protected $arr;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $arr, $user)
    {
        $this->arr = $arr;
        $this->user = $user;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Login user in console
        if (App::runningInConsole() && $this->user) {
            Auth::onceUsingId($this->user);
        }

        $clients = Client::whereIn('id', $this->arr)->get();
        foreach ($clients as $client) {
            DB::transaction(function () use ($client) {
                $client->delete();
            });
        }

        if (App::runningInConsole() && $this->user) {
            Auth::logout();
        }
    }
}
