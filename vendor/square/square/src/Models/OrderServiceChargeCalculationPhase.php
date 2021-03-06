<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents a phase in the process of calculating order totals.
 * Service charges are applied __after__ the indicated phase.
 *
 * [Read more about how order totals are calculated.](https://developer.squareup.com/docs/docs/orders-
 * api/how-it-works#how-totals-are-calculated)
 */
class OrderServiceChargeCalculationPhase
{
    /**
     * The service charge will be applied after discounts, but before
     * taxes.
     */
    public const SUBTOTAL_PHASE = 'SUBTOTAL_PHASE';

    /**
     * The service charge will be applied after all discounts and taxes
     * are applied.
     */
    public const TOTAL_PHASE = 'TOTAL_PHASE';
}
