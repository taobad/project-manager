<?php

namespace Modules\Payments\Gateways;

use App\Entities\AcceptPayment;
use Modules\Invoices\Entities\Invoice;
use Modules\Payments\Contracts\PaymentInterface;
use Modules\Payments\Helpers\Cashier;

class Checkout implements PaymentInterface
{
    protected $invoice;

    public function __construct()
    {
        $this->invoice = new Invoice;
    }

    public function pay($transaction)
    {
        $this->invoice = $this->invoice->findOrFail($transaction['ExternalReference']);
        $data = $this->getData($transaction);
        return (new Cashier($data, $this->invoice))->save();
    }

    public function getData($transaction)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'currency' => strtoupper($transaction['Currency']),
            'exchange_rate' => $this->invoice->exchange_rate,
            'client_id' => $this->invoice->client_id,
            'project_id' => $this->invoice->project_id,
            'amount' => $transaction['GrossPrice'],
            'payment_date' => dateParser(now()),
            'payment_method' => AcceptPayment::firstOrCreate(['method_name' => '2checkout'])->method_id,
            'send_email' => 1,
            'notes' => 'Paid via 2checkout by ' . $transaction['BillingDetails']['FirstName'],
            'meta' => [
                'RefNo' => $transaction['RefNo'], 'Status' => $transaction['Status'],
                'ApproveStatus' => $transaction['ApproveStatus'], 'OrderDate' => $transaction['OrderDate'],
                'Customer IP' => $transaction['PaymentDetails']['CustomerIP'], 'GrossPrice' => $transaction['GrossPrice'],
            ],
        ];
    }
}
