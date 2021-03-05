<?php

namespace Modules\Payments\Http\Controllers\Base;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Invoices\Entities\Invoice;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use Square\Models\Money;
use Square\SquareClient;

class SquareController extends Controller
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
    protected $client;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->invoice = new Invoice();
        // Initialize the Square client.
        $this->client = new SquareClient([
            'accessToken' => config('services.square.access_token'),
            'environment' => config('services.square.sandbox') ? 'sandbox' : 'production',
        ]);
    }
    /**
     *Charge using square nonce
     * @return Response
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'nonce' => 'required',
            'amount' => 'required',
            'idempotency_key' => 'required',
        ]);
        $invoice = $this->invoice->find($this->request->id);
        $payments_api = $this->client->getPaymentsApi();
        $money = new Money();
        $money->setAmount($this->request->amount * 100);
        $money->setCurrency($invoice->currency);
        $create_payment_request = new CreatePaymentRequest($this->request->nonce, $this->request->idempotency_key, $money);
        $create_payment_request->setReferenceId($invoice->id);
        try {
            $response = $payments_api->createPayment($create_payment_request);
            if ($response->isSuccess()) {
                # The payment didn’t need any additional actions and completed!
                (new \Modules\Payments\Helpers\PaymentEngine('square', json_decode($response->getBody())))->transact();
                toastr()->success('Payment via Square completed successfully.', langapp('response_status'));
                return redirect()->route('invoices.view', $invoice->id);
            } else {
                toastr()->error('Payment via Square could not be completed.', langapp('response_status'));
                \Log::error($response->getErrors());
                return redirect()->route('invoices.view', $invoice->id);
            }
        } catch (ApiException $e) {
            \Log::error($e->getResponseBody());
            throw $th;
        }
    }
}
