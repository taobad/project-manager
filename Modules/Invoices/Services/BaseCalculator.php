<?php

namespace Modules\Invoices\Services;

use Modules\Invoices\Entities\Invoice;

abstract class BaseCalculator
{
    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function subTotal()
    {
        return formatDecimal($this->invoice->items->sum('total_cost'));
    }
    public function subtotalWithDiscount()
    {
        return $this->subTotal() - $this->discounted();
    }

    public function creditedAmount()
    {
        return $this->invoice->credited()->sum('credited_amount');
    }

    public function extraFee()
    {
        if ($this->invoice->fee_is_percent === 1) {
            return formatDecimal(($this->invoice->extra_fee / 100) * $this->invoice->subTotal());
        }

        return formatDecimal($this->invoice->extra_fee);
    }

    public function taxTypeAmount($taxes)
    {
        $amount = 0;
        foreach ($taxes as $tax) {
            if ($tax->compound_tax == 1) {
                $amount += (($this->subtotalWithDiscount() + $this->totalSimpleTax()) * $tax->percent) / 100;
            } else {
                $amount += ($this->subtotalWithDiscount() * $tax->percent) / 100;
            }
        }
        return $amount;
    }

    public function totalSimpleTax()
    {
        $amount = 0;
        foreach ($this->invoice->taxes as $tax) {
            if ($tax->compound_tax == 0) {
                $amount += (($this->subtotalWithDiscount()) * $tax->percent) / 100;
            }
        }
        return $amount;
    }
    public function totalCompoundTax()
    {
        $amount = 0;
        foreach ($this->invoice->taxes as $tax) {
            if ($tax->compound_tax) {
                $amount += (($this->subtotalWithDiscount() + $this->totalSimpleTax()) * $tax->percent) / 100;
            }
        }
        return $amount;
    }
    public function totalTaxes()
    {
        if ($this->invoice->tax_per_item == 0) {
            return $this->totalSimpleTax() + $this->totalCompoundTax();
        }
        return $this->invoice->items()->sum('tax_total');
    }
    public function totalTax()
    {
        $amount = 0;
        foreach ($this->invoice->taxes as $tax) {
            if ($tax->compound_tax) {
                $amount += (($this->subtotalWithDiscount() + $this->totalSimpleTax()) * $tax->percent) / 100;
            } else {
                $amount += ($this->subtotalWithDiscount() * $tax->percent) / 100;
            }
        }
        return $amount;
    }

    public function tax1Amount()
    {
        return formatDecimal(($this->invoice->tax / 100) * $this->invoice->subTotal());
    }

    public function tax2Amount()
    {
        return formatDecimal(($this->invoice->tax2 / 100) * $this->invoice->subTotal());
    }

    public function lateFee()
    {
        if ($this->invoice->isOverdue() && settingEnabled('final_reminder_late_fee') && now()->diffInDays($this->invoice->due_date) >= get_option('invoices_overdue_reminder3')) {
            if ($this->invoice->late_fee_percent === 1) {
                return formatDecimal(($this->invoice->late_fee / 100) * $this->invoice->subTotal());
            }
            return formatDecimal($this->invoice->late_fee);
        }
        return 0.00;
    }
    public function discounted()
    {
        if ($this->invoice->discount_percent == 1) {
            return ($this->subTotal() * $this->invoice->discount) / 100;
        } else {
            return $this->invoice->discount;
        }
    }
    public function due()
    {
        $invoiceTotal = ($this->subTotal() - $this->discounted()) + $this->totalTax();
        $bal = ($invoiceTotal + $this->extraFee() + $this->lateFee()) - $this->paid();
        return $bal <= 0 ? 0 : formatDecimal($bal - $this->creditedAmount());
    }

    public function paid()
    {
        $amount = 0;
        foreach ($this->invoice->payments()->active()->get() as $paid) {
            if ($paid->currency != $this->invoice->currency) {
                $amount += convertCurrency($paid->currency, $paid->amount, $this->invoice->currency, $this->invoice->exchange_rate);
            } else {
                $amount += $paid->amount;
            }
        }

        return formatDecimal($amount);
    }

    public function payable()
    {
        $invoiceTotal = ($this->subTotal() - $this->discounted()) + $this->totalTax();
        return formatDecimal($invoiceTotal + $this->extraFee() + $this->lateFee());
    }

    public function excTax()
    {
        return formatDecimal(($this->invoice->subTotal() + $this->invoice->extraFee()) - $this->invoice->discounted());
    }
}
