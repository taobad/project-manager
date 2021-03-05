<?php

namespace Modules\Items\Entities;

use App\Entities\Taxes;
use App\Traits\Observable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Items\Observers\ItemObserver;

class Item extends Model
{
    use Observable, HasFactory;

    protected static $observer = ItemObserver::class;
    protected static $scope = null;

    protected $fillable = [
        'tax_rate', 'tax_total', 'quantity', 'unit_cost', 'discount', 'total_cost', 'name', 'description',
        'order', 'itemable_id', 'itemable_type',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'discount' => 'float',
        'tax_rate' => 'float',
        'quantity' => 'float',
        'unit_cost' => 'float',
        'total_cost' => 'float',
    ];

    public function taxes()
    {
        return $this->hasMany(Taxes::class)->orderBy('id', 'desc');
    }

    public function itemable()
    {
        if ($this->itemable_id > 0) {
            return $this->morphTo();
        }
    }

    public function scopeTemplates($query)
    {
        return $query->whereItemableId(0);
    }

    public function setTaxRateAttribute($value)
    {
        $this->attributes['tax_rate'] = is_null($value) ? 0.00 : $value;
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\ItemFactory::new ();
    }
}
