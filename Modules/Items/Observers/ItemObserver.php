<?php

namespace Modules\Items\Observers;

use Modules\Estimates\Entities\Estimate;
use Modules\Items\Entities\Item;

class ItemObserver
{
    /**
     * Listen to the Item creating event.
     *
     * @param Item $item
     */
    public function saving(Item $item)
    {
        $subTotal = $item->unit_cost * $item->quantity;
        $item->total_cost = formatDecimal($subTotal - (($item->discount / 100) * $subTotal));
    }

    /**
     * Listen to the Item saved event.
     *
     * @param Item $item
     */
    public function saved(Item $item)
    {
        if ($item->itemable_type === Estimate::class) {
            if ($item->itemable->deal_id > 0) {
                $item->itemable->deal->update(['currency' => $item->itemable->currency, 'deal_value' => $item->itemable->amount]);
            }
        }
        if ($item->itemable_id > 0) {
            $item->itemable->afterModelSaved();
        }
    }

    /**
     * Listen to the Item deleting event.
     *
     * @param Item $item
     */
    public function deleted(Item $item)
    {
        $item->itemable_id > 0 ? $item->itemable->afterModelSaved() : '';
        if ($item->itemable_type === Estimate::class) {
            if ($item->itemable->deal_id > 0) {
                $item->itemable->deal->update(['currency' => $item->itemable->currency, 'deal_value' => $item->itemable->amount]);
            }
        }
    }
}
