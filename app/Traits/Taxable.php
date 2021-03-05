<?php

namespace App\Traits;

use App\Entities\Taxes;

trait Taxable
{
    public function taxes()
    {
        return $this->morphMany(Taxes::class, 'taxable')->orderBy('id', 'desc');
    }
}
