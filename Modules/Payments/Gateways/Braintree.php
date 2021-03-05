<?php

namespace Modules\Payments\Gateways;

use App\Entities\AcceptPayment;
use Modules\Invoices\Entities\Invoice;
use Modules\Payments\Contracts\PaymentInterface;
use Modules\Payments\Helpers\Cashier;

class Braintree implements PaymentInterface
{
    protected $invoice;

    public function __construct()
    {
        $this->invoice = new Invoice;
    }

    public function pay($transaction)
    {
        $this->invoice = $this->invoice->findOrFail($transaction->orderId);
        $data = $this->getData($transaction);
        return (new Cashier($data, $this->invoice))->save();
    }
    public function getData($transaction)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'currency' => $transaction->currencyIsoCode,
            'exchange_rate' => $this->invoice->exchange_rate,
            'client_id' => $this->invoice->client_id,
            'project_id' => $this->invoice->project_id,
            'amount' => $transaction->amount,
            'payment_date' => dateParser(now()),
            'payment_method' => AcceptPayment::firstOrCreate(['method_name' => 'Braintree'])->method_id,
            'send_email' => 1,
            'notes' => 'Paid via Braintree to Merchant Account ' . $transaction->merchantAccountId,
            'meta' => [
                'id' => $transaction->id, 'status' => $transaction->status, 'currency' => $transaction->currencyIsoCode,
                'merchantAccountId' => $transaction->merchantAccountId,
            ],
        ];
    }
}
