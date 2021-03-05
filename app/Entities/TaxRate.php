<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    protected $guarded = [];
    protected $table = 'tax_rates';

    public function getRateAttribute($value)
    {
        return formatTax($value);
    }
}
