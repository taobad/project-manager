<?php

namespace Modules\Payments\Http\Controllers\Base;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Invoices\Entities\Invoice;
use Mollie\Laravel\Facades\Mollie;

abstract class MollieController extends Controller
{
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Invoice model
     *
     * @var \Modules\Invoices\Entities\Invoice
     */
    protected $invoice;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->invoice = new Invoice;
    }
    /**
     * Mollie Checkout
     */
    public function checkout()
    {
        $invoice = $this->invoice->find($this->request->id);
        try {
            $authUserName = Auth::check() ? Auth::user()->name : optional($invoice->company->contact)->name;
            $payment = Mollie::api()->payments()->create(
                [
                    'amount' => [
                        'currency' => $invoice->currency,
                        'value' => formatDecimal($this->request->amount),
                    ],
                    'description' => 'Payment for Invoice #' . $invoice->reference_no . ' via Mollie',
                    'webhookUrl' => route('mollie.ipn'),
                    'redirectUrl' => route('invoices.view', $invoice->id),
                    'method' => config('mollie.methods'),
                    'metadata' => [
                        'invoice_id' => $invoice->id,
                        'payer' => $authUserName,
                        'payer_email' => $invoice->company->email,
                        'code' => $invoice->reference_no,
                    ],
                ]
            );

            $payment = Mollie::api()->payments()->get($payment->id);
            return redirect($payment->getCheckoutUrl(), 303);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            toastr()->error('Payment failed please contact admin', langapp('response_status'));
            return redirect()->route('invoices.index');
        }
    }
}
