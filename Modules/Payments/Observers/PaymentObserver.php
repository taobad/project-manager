<?php

namespace Modules\Payments\Observers;

use Illuminate\Support\Facades\Artisan;
use Modules\Payments\Entities\Payment;

class PaymentObserver
{

    /**
     * Listen to the Payment saving event.
     *
     * @param Payment $payment
     */
    public function saving(Payment $payment)
    {
        if (empty($payment->code) || $payment->code == '' || is_null($payment->code)) {
            $payment->code = generateCode('payments');
        }
        $payment->exchange_rate = empty($payment->exchange_rate) ? xchangeRate($payment->currency) : $payment->exchange_rate;
        $payment->amount_formatted = formatCurrency($payment->currency, $payment->amount);
    }

    /**
     * Listen to the Payment saved event.
     *
     * @param Payment $payment
     */
    public function saved(Payment $payment)
    {
        if (request()->has('tags')) {
            $payment->retag(collect(request('tags'))->implode(','));
        }
        $payment->afterModelSaved();
        $payment->AsInvoice->afterModelSaved();
    }

    /**
     * Listen to the Payment deleting event.
     *
     * @param Payment $payment
     */
    public function deleting(Payment $payment)
    {
        foreach ($payment->files as $file) {
            $file->delete();
        }
        foreach ($payment->comments as $comment) {
            $comment->delete();
        }
        foreach ($payment->activities as $activity) {
            $activity->delete();
        }
        $payment->detag();
    }
    /**
     * Listen to the Payment deleted event.
     *
     * @param Payment $payment
     */
    public function deleted(Payment $payment)
    {
        $payment->AsInvoice->afterModelSaved();
        Artisan::call('analytics:payments');
    }
}
