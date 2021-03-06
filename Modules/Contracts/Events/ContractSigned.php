<?php

namespace Modules\Contracts\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Contracts\Entities\Contract;

class ContractSigned
{
    use SerializesModels;

    public $contract;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
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
