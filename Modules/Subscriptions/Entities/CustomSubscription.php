<?php

namespace Modules\Subscriptions\Entities;

use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;

class CustomSubscription extends Subscription
{
    protected $dates = [
        'trial_ends_at', 'ends_at',
        'created_at', 'updated_at',
    ];

    protected $table = 'subscriptions';

    /**
     * Get the subscription items related to the subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(SubscriptionItem::class, 'subscription_id');
    }
}
