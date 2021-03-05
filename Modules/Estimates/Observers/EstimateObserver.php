<?php

namespace Modules\Estimates\Observers;

use Modules\Clients\Entities\Client;
use Modules\Estimates\Entities\Estimate;

class EstimateObserver
{
    /**
     * Listen to the Estimate creating event.
     *
     * @param \Modules\Estimates\Entities\Estimate $estimate
     */
    public function creating(Estimate $estimate)
    {
        $estimate->reference_no = generateCode('estimates');
        if (!is_numeric($estimate->client_id)) {
            $estimate->client_id = Client::firstOrCreate(
                ['email' => $estimate->client_id],
                ['name' => $estimate->client_id]
            )->id;
        }
        if (empty($estimate->due_date)) {
            $estimate->due_date = now()->addDays(get_option('invoices_due_after', '15'));
        }
        $estimate->exchange_rate = xchangeRate($estimate->currency);
    }

    /**
     * Listen to the Estimate saved event.
     *
     * @param \Modules\Estimates\Entities\Estimate $estimate
     */
    public function saved(Estimate $estimate)
    {
        if (request()->has('tags')) {
            $estimate->retag(collect(request('tags'))->implode(','));
        }
        if ($estimate->deal_id > 0) {
            $estimate->deal->update(['currency' => $estimate->currency, 'deal_value' => $estimate->amount()]);
        }
        $estimate->afterModelSaved();
        $estimate->saveCustom(request('custom'));
    }

    /**
     * Listen to the Estimate deleting event.
     *
     * @param \Modules\Estimates\Entities\Estimate $estimate
     */
    public function deleting(Estimate $estimate)
    {
        foreach ($estimate->items as $item) {
            $item->delete();
        }
        foreach ($estimate->activities as $activity) {
            $activity->delete();
        }
        foreach ($estimate->comments as $comment) {
            $comment->delete();
        }
        foreach ($estimate->schedules as $event) {
            $event->delete();
        }
        foreach ($estimate->files as $file) {
            $file->delete();
        }
        foreach ($estimate->custom as $field) {
            $field->delete();
        }
        $estimate->detag();
    }
    /**
     * Listen to the Estimate deleted event.
     *
     * @param Estimate $estimate
     */
    public function deleted(Estimate $estimate)
    {
        \Artisan::call('analytics:estimates');
    }
}
