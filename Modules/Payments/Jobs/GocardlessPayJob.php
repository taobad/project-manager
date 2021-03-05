<?php

namespace Modules\Payments\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Clients\Entities\Client;
use Modules\Payments\Entities\GocardlessMandate;

class GocardlessPayJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    protected $mandate;
    protected $client;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GocardlessMandate $mandate)
    {
        $this->mandate = $mandate;
        $this->client = new \GoCardlessPro\Client([
            'access_token' => config('gocardless.token'),
            'environment' => config('gocardless.environment') == 'SANDBOX' ? \GoCardlessPro\Environment::SANDBOX : \GoCardlessPro\Environment::LIVE,
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payment = $this->client->payments()->create([
            "params" => [
                "amount" => $this->mandate->amount,
                "currency" => $this->mandate->invoice->currency,
                "links" => [
                    "mandate" => $this->mandate->gocardless_mandate,
                ],
                "metadata" => [
                    "invoice_id" => (string) $this->mandate->invoice->id,
                    "invoice_reference" => $this->mandate->invoice->reference_no,
                ],
            ],
            "headers" => [
                "Idempotency-Key" => $this->mandate->idempotency_key,
            ],
        ]);
        $this->mandate->update(['payment_id' => $payment->id]);
        //uncomment this if you want to see what response is returned in the logs
        //$response = (string) $this->client->payments()->get($payment->id);
        //\Log::error($response);
    }
}
