<?php

use App\Entities\CsvData;
use Modules\Activity\Entities\Activity;

return [

    /*
     * All models in this array that implement `Spatie\ModelCleanup\GetsCleanedUp`
     * will be cleaned.
     */
    'models' => [
        Activity::class,
        CsvData::class,
    ],
];
