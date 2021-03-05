<?php

namespace App\Entities;

use App\Entities\TaxRate;
use Illuminate\Database\Eloquent\Model;

class Taxes extends Model
{
    protected $guarded = [];
    protected $table = 'taxes';

    public function getPercentAttribute($value)
    {
        return formatTax($value);
    }

    public function taxtype()
    {
        return $this->belongsTo(TaxRate::class, 'tax_type_id');
    }
}
