<?php

namespace Modules\Payments\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Invoices\Entities\Invoice;
use Stripe\Stripe;

abstract class StripeController extends Controller
{
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Invoice Model
     *
     * @var Invoice
     */
    protected $invoice;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->invoice = new Invoice;
    }

    public function intent()
    {
        Stripe::setApiKey(config('cashier.secret'));
        $intent = null;
        $invoice = Invoice::findOrFail($this->request->id);
        try {
            if ($this->request->has('payment_method_id')) {
                # Create the PaymentIntent
                $intent = \Stripe\PaymentIntent::create([
                    'payment_method' => $this->request->payment_method_id,
                    'amount' => $this->request->amount * 100,
                    'currency' => strtolower($this->request->currency),
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                    'description' => 'Payment for Invoice #' . $invoice->reference_no,
                    'metadata' => [
                        'invoice_id' => $invoice->id,
                        'payer' => Auth::check() ? Auth::user()->name : optional($invoice->company->contact)->name,
                        'payer_email' => $invoice->company->email,
                        'code' => $invoice->reference_no,
                    ],
                ]);
            }
            if ($this->request->has('payment_intent_id')) {
                $intent = \Stripe\PaymentIntent::retrieve(
                    $this->request->payment_intent_id
                );
                $intent->confirm();
            }
            return $this->generatePaymentResponse($intent, $invoice);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            # Display error on client
            return [
                'error' => $e->getMessage(),
            ];
        }
        return $intent;
    }

    public function generatePaymentResponse($intent, $invoice)
    {
        # Note that if your API version is before 2019-02-11, 'requires_action'
        # appears as 'requires_source_action'.
        if ($intent->status == 'requires_action' &&
            $intent->next_action->type == 'use_stripe_sdk') {
            # Tell the client to handle the action
            return [
                'requires_action' => true,
                'payment_intent_client_secret' => $intent->client_secret,
            ];
        } elseif ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            (new \Modules\Payments\Helpers\PaymentEngine('stripe', $intent))->transact();
            return [
                "success" => true,
                "redirect" => route('invoices.view', $invoice->id),
                "intent" => $intent,
            ];
        } else {
            # Invalid status
            http_response_code(500);
            return ['error' => 'Invalid PaymentIntent status'];
        }
    }
}
