<?php

namespace Modules\Contracts\Observers;

use Modules\Contracts\Entities\Contract;

class ContractObserver
{
    /**
     * Listen to the Contract creating event.
     *
     * @param Contract $contract
     */
    public function creating(Contract $contract)
    {
        $contract->user_id = \Auth::check() ? \Auth::id() : firstAdminId();
    }

    /**
     * Listen to the Contract deleting event.
     *
     * @param Contract $contract
     */
    public function deleting(Contract $contract)
    {
        foreach ($contract->activities as $activity) {
            $activity->delete();
        }
        foreach ($contract->files as $file) {
            $file->delete();
        }
        foreach ($contract->comments as $comment) {
            $comment->delete();
        }
        $contract->detag();
    }
}
