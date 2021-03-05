<?php

namespace Modules\Payments\Http\Controllers\Base;

use Braintree\Gateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Invoices\Entities\Invoice;

class BraintreeController extends Controller
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
     * @var \Modules\Invoices\Entities\Invoice
     */
    protected $invoice;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->invoice = new Invoice;
    }

    public function checkout()
    {
        $this->request->validate(
            [
                'nonce' => 'required',
                'amount' => 'required',
                'id' => 'required|numeric',
            ]
        );
        $invoice = $this->invoice->find($this->request->id);
        $merchantAccount = isset($invoice->gateways['braintree_merchant_account']) ? $invoice->gateways['braintree_merchant_account'] : config('services.braintree.merchantId');
        $gateway = new Gateway(
            [
                'environment' => settingEnabled('braintree_live') ? 'production' : 'sandbox',
                'merchantId' => config('services.braintree.merchantId'),
                'publicKey' => config('services.braintree.publicKey'),
                'privateKey' => config('services.braintree.privateKey'),
            ]
        );

        try {
            $authUserName = Auth::check() ? Auth::user()->name : optional($invoice->company->contact)->name;
            $result = $gateway->transaction()->sale(
                [
                    'amount' => $this->request->amount,
                    'orderId' => $this->request->id,
                    'customer' => [
                        'firstName' => splitNames($authUserName)['firstName'],
                        'lastName' => splitNames($authUserName)['lastName'],
                        'company' => $invoice->company->name,
                        'phone' => $invoice->company->phone,
                        'fax' => $invoice->company->fax,
                        'website' => $invoice->company->website,
                        'email' => $invoice->company->email,
                    ],
                    'merchantAccountId' => $merchantAccount,
                    'paymentMethodNonce' => $this->request->nonce,
                    'options' => [
                        'submitForSettlement' => true,
                    ],
                ]
            );
            if ($result->success) {
                $txn = $result->transaction;
                (new \Modules\Payments\Helpers\PaymentEngine('braintree', $txn))->transact();
                toastr()->success('Payment processed successfully', langapp('response_status'));
                return redirect()->route('invoices.view', $invoice->id);
            }
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            toastr()->error('Payment failed please contact admin', langapp('response_status'));
            return redirect()->route('invoices.index', $invoice->id);
        }
    }
}
