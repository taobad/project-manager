<?php

namespace Modules\Invoices\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Modules\Invoices\Entities\Invoice;

class MergeInvoices
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
        $this->model = new Invoice;
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
        $deniedStatuses = ['fully_paid', 'partially_paid'];
        $firstInvoice = $invoices->first();
        $client = $firstInvoice->client_id;
        $currency = $firstInvoice->currency;
        $items = array();
        foreach ($invoices as $invoice) {
            if ($invoice->client_id == $client && $invoice->currency == $currency && !in_array($invoice->getRawOriginal('status'), $deniedStatuses)) {
                $items[] = $invoice->items->toArray();
            }
        }
        $newInvoice = $this->model->create([
            'title' => $firstInvoice->title,
            'client_id' => $client,
            'due_date' => now()->addDays(get_option('invoices_due_after', '15'))->toDateTimeString(),
            'notes' => $firstInvoice->notes,
            'tax' => $firstInvoice->tax,
            'tax2' => $firstInvoice->tax2,
            'discount' => $firstInvoice->discount,
            'currency' => $currency,
            'extra_fee' => $firstInvoice->extra_fee,
            'fee_is_percent' => $firstInvoice->fee_is_percent,
            'exchange_rate' => $firstInvoice->exchange_rate,
            'discount_percent' => $firstInvoice->discount_percent,
            'project_id' => $firstInvoice->project_id,
            'late_fee' => $firstInvoice->late_fee,
            'late_fee_percent' => $firstInvoice->late_fee_percent,
            'gateways' => $firstInvoice->gateways,
            'is_visible' => $firstInvoice->is_visible,
        ]);
        foreach ($items as $item) {
            $newInvoice->items()->createMany($item);
        }
        $invoices->each(function ($inv) {
            $inv->update(['cancelled_at' => now()->toDateTimeString()]);
        });
    }
}
