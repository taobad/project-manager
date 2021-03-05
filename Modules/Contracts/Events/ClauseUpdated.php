<?php

namespace Modules\Contracts\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Contracts\Entities\Clause;

class ClauseUpdated
{
    use SerializesModels;
    
    public $clause;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Clause $clause)
    {
        $this->clause = $clause;
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
