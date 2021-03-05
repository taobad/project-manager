<?php

namespace Modules\Estimates\Services;

use Modules\Estimates\Entities\Estimate;

abstract class BaseCalculator
{
    protected $estimate;

    public function __construct(Estimate $estimate)
    {
        $this->estimate = $estimate;
    }

    public function subTotal()
    {
        return formatDecimal($this->estimate->items->sum('total_cost'));
    }
    public function subtotalWithDiscount()
    {
        return $this->subTotal() - $this->discounted();
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
        foreach ($this->estimate->taxes as $tax) {
            if ($tax->compound_tax == 0) {
                $amount += (($this->subtotalWithDiscount()) * $tax->percent) / 100;
            }
        }
        return $amount;
    }
    public function totalCompoundTax()
    {
        $amount = 0;
        foreach ($this->estimate->taxes as $tax) {
            if ($tax->compound_tax) {
                $amount += (($this->subtotalWithDiscount() + $this->totalSimpleTax()) * $tax->percent) / 100;
            }
        }
        return $amount;
    }
    public function totalTaxes()
    {
        if ($this->estimate->tax_per_item == 0) {
            return $this->totalSimpleTax() + $this->totalCompoundTax();
        }
        return $this->estimate->items()->sum('tax_total');
    }
    public function totalTax()
    {
        $amount = 0;
        foreach ($this->estimate->taxes as $tax) {
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
        return formatDecimal(($this->estimate->tax / 100) * $this->estimate->subTotal());
    }

    public function tax2Amount()
    {
        return formatDecimal(($this->estimate->tax2 / 100) * $this->estimate->subTotal());
    }

    public function discounted()
    {
        if ($this->estimate->discount_percent == 1) {
            return ($this->subTotal() * $this->estimate->discount) / 100;
        } else {
            return $this->estimate->discount;
        }
    }

    public function amount()
    {
        return ($this->subTotal() - $this->discounted()) + $this->totalTax();
    }
}
