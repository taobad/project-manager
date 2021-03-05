<?php

namespace Modules\Contracts\Entities;

use Illuminate\Database\Eloquent\Model;

class ContractTemplate extends Model
{
    protected $fillable = ['name', 'body'];
}
