<?php

namespace Modules\Updates\Events;

use Illuminate\Queue\SerializesModels;

class UpdateSuccessful
{
    use SerializesModels;

    public $user;
    public $installed;
    public $old_version;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $installed, $old_version)
    {
        $this->user = $user;
        $this->installed = $installed;
        $this->old_version = $old_version;
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
