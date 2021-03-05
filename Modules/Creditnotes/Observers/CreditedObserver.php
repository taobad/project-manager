<?php

namespace Modules\Creditnotes\Observers;

use Modules\Creditnotes\Entities\Credited;
use Modules\Creditnotes\Entities\CreditNote;

class CreditedObserver
{

    /**
     * Listen to the Credited created event.
     *
     * @param \Modules\Creditnotes\Entities\Credited $credited
     */
    public function created(Credited $credited)
    {
    }

    /**
     * Listen to the Credited saved event.
     *
     * @param \Modules\Creditnotes\Entities\Credited $credited
     */
    public function saved(Credited $credited)
    {
        $credited->credit->afterModelSaved();
        $credited->invoice->afterModelSaved();
    }

    /**
     * Listen to the Credited deleting event.
     *
     * @param \Modules\Creditnotes\Entities\Credited $credited
     */
    public function deleted(Credited $credited)
    {
        $credited->credit->afterModelSaved();
        $credited->invoice->afterModelSaved();
    }
}
