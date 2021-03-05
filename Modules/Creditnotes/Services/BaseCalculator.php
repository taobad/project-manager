<?php

namespace Modules\Creditnotes\Services;

use Modules\Creditnotes\Entities\CreditNote;

abstract class BaseCalculator
{
    protected $creditnote;

    public function __construct(CreditNote $creditnote)
    {
        $this->creditnote = $creditnote;
    }
    public function subTotal()
    {
        return formatDecimal($this->creditnote->items->sum('total_cost'));
    }

    public function taxTypeAmount($taxes)
    {
        $amount = 0;
        foreach ($taxes as $tax) {
            if ($tax->compound_tax == 1) {
                $amount += (($this->subTotal() + $this->totalSimpleTax()) * $tax->percent) / 100;
            } else {
                $amount += ($this->subTotal() * $tax->percent) / 100;
            }
        }
        return $amount;
    }

    public function totalSimpleTax()
    {
        $amount = 0;
        foreach ($this->creditnote->taxes as $tax) {
            if ($tax->compound_tax == 0) {
                $amount += (($this->subTotal()) * $tax->percent) / 100;
            }
        }
        return $amount;
    }
    public function totalCompoundTax()
    {
        $amount = 0;
        foreach ($this->creditnote->taxes as $tax) {
            if ($tax->compound_tax) {
                $amount += (($this->subTotal() + $this->totalSimpleTax()) * $tax->percent) / 100;
            }
        }
        return $amount;
    }
    public function totalTaxes()
    {
        if ($this->creditnote->tax_per_item == 0) {
            return $this->totalSimpleTax() + $this->totalCompoundTax();
        }
        return $this->creditnote->items()->sum('tax_total');
    }
    public function totalTax()
    {
        $amount = 0;
        foreach ($this->creditnote->taxes as $tax) {
            if ($tax->compound_tax) {
                $amount += (($this->subTotal() + $this->totalSimpleTax()) * $tax->percent) / 100;
            } else {
                $amount += ($this->subTotal() * $tax->percent) / 100;
            }
        }
        return $amount;
    }

    public function balance()
    {
        return $this->total() - $this->creditnote->credited->sum('credited_amount');
    }

    public function total()
    {
        return formatDecimal($this->subTotal() + $this->totalTax());
    }
    public function tax1Amount()
    {
        return formatDecimal(($this->creditnote->tax / 100) * $this->subTotal());
    }
}
