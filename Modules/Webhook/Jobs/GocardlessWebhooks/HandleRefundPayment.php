<?php

namespace Modules\Webhook\Jobs\GocardlessWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Payments\Entities\GocardlessMandate;
use Modules\Payments\Entities\Payment;
use Nestednet\Gocardless\GocardlessWebhookCall;

class HandleRefundPayment implements ShouldQueue
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
        $txn = Payment::where(['invoice_id' => $mandate->invoice->id, 'amount' => $mandate->amount / 100])->first();
        if (isset($txn->id)) {
            $txn->update(['is_refunded' => 1]);
        }
    }
}
