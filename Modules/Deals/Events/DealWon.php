<?php

namespace Modules\Deals\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Deals\Entities\Deal;

class DealWon
{
    use SerializesModels;

    public $deal;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
