<?php

namespace Modules\Payments\Gateways;

use App\Entities\AcceptPayment;
use Modules\Invoices\Entities\Invoice;
use Modules\Payments\Contracts\PaymentInterface;
use Modules\Payments\Helpers\Cashier;

class Square implements PaymentInterface
{
    protected $invoice;

    public function __construct()
    {
        $this->invoice = new Invoice;
    }

    public function pay($transaction)
    {
        $this->invoice = $this->invoice->findOrFail($transaction->payment->reference_id);
        $data = $this->getData($transaction);
        return (new Cashier($data, $this->invoice))->save();
    }

    public function getData($charge)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'currency' => strtoupper($charge->payment->amount_money->currency),
            'exchange_rate' => $this->invoice->exchange_rate,
            'client_id' => $this->invoice->client_id,
            'project_id' => $this->invoice->project_id,
            'amount' => $charge->payment->amount_money->amount / 100,
            'payment_date' => dateParser(now()),
            'payment_method' => AcceptPayment::firstOrCreate(['method_name' => 'Square'])->method_id,
            'send_email' => 1,
            'notes' => 'Square transaction ID ' . $charge->payment->id . ' and status ' . $charge->payment->status,
            'meta' => [
                'sourceType' => $charge->payment->source_type, 'orderId' => $charge->payment->order_id,
                'receipt' => $charge->payment->receipt_url, 'date' => $charge->payment->created_at,
            ],
        ];
    }
}
