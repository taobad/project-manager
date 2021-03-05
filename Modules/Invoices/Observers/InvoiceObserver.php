<?php

namespace Modules\Invoices\Observers;

use App\Traits\Taggable;
use Modules\Clients\Entities\Client;
use Modules\Expenses\Entities\Expense;
use Modules\Invoices\Entities\Invoice;

class InvoiceObserver
{
    use Taggable;
    /**
     * Listen to the Invoice created event.
     *
     * @param \Modules\Invoices\Entities\Invoice $invoice
     */
    public function creating(Invoice $invoice)
    {
        if (!is_numeric($invoice->client_id)) {
            $invoice->client_id = Client::firstOrCreate(
                ['email' => $invoice->client_id],
                ['owner' => \Auth::id(), 'name' => $invoice->client_id]
            )->id;
        }
        $invoice->is_visible = empty($invoice->is_visible) ? 0 : $invoice->is_visible;
        if ((is_string($invoice->due_date) || is_null($invoice->due_date)) && strlen($invoice->due_date) == 0) {
            $invoice->due_date = now()->addDays(get_option('invoices_due_after', '15'))->toDateTimeString();
        }
        $invoice->exchange_rate = xchangeRate($invoice->currency);
        if (empty($invoice->reference_no) || settingEnabled('increment_invoice_number')) {
            $invoice->reference_no = generateCode('invoices');
        }
    }

    /**
     * Listen to the Invoice updated event.
     *
     * @param \Modules\Invoices\Entities\Invoice $invoice
     */
    public function updated(Invoice $invoice)
    {
        if ($invoice->hasPayment()) {
            $invoice->payments()->update(['client_id' => $invoice->client_id]);
        }
    }

    /**
     * Listen to the Invoice saved event.
     *
     * @param \Modules\Invoices\Entities\Invoice $invoice
     */
    public function saved(Invoice $invoice)
    {
        if (request()->has('tags')) {
            $invoice->retag(collect(request('tags'))->implode(','));
        }
        $invoice->saveCustom(request('custom'));
        $invoice->afterModelSaved();
    }

    /**
     * Listen to the Invoice deleting event.
     *
     * @param \Modules\Invoices\Entities\Invoice $invoice
     */
    public function deleting(Invoice $invoice)
    {
        foreach ($invoice->items as $item) {
            $item->delete();
        }
        foreach ($invoice->payments as $payment) {
            $payment->delete();
        }
        foreach ($invoice->credited as $cr) {
            $cr->delete();
        }
        foreach ($invoice->installments as $partial) {
            $partial->delete();
        }
        foreach ($invoice->activities as $activity) {
            $activity->delete();
        }
        foreach ($invoice->comments as $comment) {
            $comment->delete();
        }
        foreach ($invoice->schedules as $event) {
            $event->delete();
        }
        $invoice->detag();
        $invoice->recurring()->delete();

        Expense::where('invoiced_id', $invoice->id)->update(['invoiced_id' => null]);
    }

    /**
     * Listen to the Invoice deleted event.
     *
     * @param Invoice $invoice
     */
    public function deleted(Invoice $invoice)
    {
        \Artisan::call('analytics:invoices');
    }
}
