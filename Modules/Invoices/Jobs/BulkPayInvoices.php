<?php

namespace Modules\Invoices\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Invoices\Entities\Invoice;
use Modules\Payments\Helpers\Cashier;

class BulkPayInvoices implements ShouldQueue
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $arr)
    {
        $this->arr = $arr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoices = Invoice::whereIn('id', $this->arr)->get();
        foreach ($invoices as $invoice) {
            $data = $this->getData($invoice);
            $cashier = new Cashier($data, $invoice);
            $cashier->save();
            $invoice->afterModelSaved();
        }
    }

    public function getData($invoice)
    {
        return [
            'invoice_id' => $invoice->id,
            'currency' => $invoice->currency,
            'exchange_rate' => $invoice->exchange_rate,
            'client_id' => $invoice->client_id,
            'project_id' => $invoice->project_id,
            'amount' => $invoice->due(),
            'payment_date' => now()->format(config('system.preferred_date_format')),
            'payment_method' => 2,
            'send_email' => settingEnabled('send_thank_you_email') ? 1 : 0,
            'notes' => $invoice->notes,
            'meta' => [],
        ];
    }
}
