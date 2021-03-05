<?php

namespace Modules\Webhook\Jobs\GocardlessWebhooks;

use App\Entities\AcceptPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Payments\Entities\GocardlessMandate;
use Nestednet\Gocardless\GocardlessWebhookCall;

class HandleConfirmedPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(GocardlessWebhookCall $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payment_id = $this->data['payload']['links']['payment'];
        $mandate = GocardlessMandate::where('payment_id', $payment_id)->first();
        $txn = [
            'invoice_id' => $mandate->invoice->id,
            'amount' => $mandate->amount / 100,
            'payment_method' => AcceptPayment::firstOrCreate(['method_name' => $this->data['payload']['details']['origin']])->method_id,
            'send_email' => 1,
            'notes' => $this->data['payload']['details']['description'],
            'meta' => [
                'payment_id' => $payment_id,
                'action' => $this->data['payload']['action'],
            ],
        ];
        (new \Modules\Payments\Helpers\PaymentEngine('gocardless', $txn))->transact();
    }
}
