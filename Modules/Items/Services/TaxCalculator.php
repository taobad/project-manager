<?php

namespace Modules\Items\Services;

use App\Entities\TaxRate;

class TaxCalculator
{
    protected $entity;
    protected $item;
    protected $rates;

    public function __construct($entity, $item, array $rates)
    {
        $this->entity = $entity;
        $this->item = $item;
        $this->rates = $rates;
    }

    public function saveTaxes()
    {
        $subTotal = $this->item->total_cost;
        $taxes = TaxRate::whereIn('id', $this->rates)->get();
        $simpleTaxesPercent = $taxes->where('compound_tax', 0)->sum('rate');
        $compoundTaxesPercent = $taxes->where('compound_tax', 1)->sum('rate');
        $itemSimpleTax = ($simpleTaxesPercent / 100) * ($subTotal);
        $itemCompoundTax = ($compoundTaxesPercent / 100) * (($subTotal) + $itemSimpleTax);
        $taxTotal = $itemSimpleTax + $itemCompoundTax;
        $this->item->update(['tax_total' => $taxTotal]);
        $simpleTax = 0;
        foreach ($taxes->where('compound_tax', 0) as $tax) {
            $this->entity->taxes()->create([
                'tax_type_id' => $tax->id,
                'item_id' => $this->item->id,
                'client_id' => $this->entity->client_id,
                'name' => $tax->name,
                'amount' => $subTotal * ($tax->rate / 100),
                'percent' => $tax->rate,
                'compound_tax' => $tax->compound_tax,
            ]);
            $simpleTax += $subTotal * ($tax->rate / 100);
        }
        foreach ($taxes->where('compound_tax', 1) as $tax) {
            $this->entity->taxes()->create([
                'tax_type_id' => $tax->id,
                'item_id' => $this->item->id,
                'client_id' => $this->entity->client_id,
                'name' => $tax->name,
                'amount' => ($subTotal + $simpleTax) * ($tax->rate / 100),
                'percent' => $tax->rate,
                'compound_tax' => $tax->compound_tax,
            ]);
        }
    }
}
