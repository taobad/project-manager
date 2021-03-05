<?php

namespace Modules\Teams\Entities;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Teams\Events\AssignmentDeleted;

class Assignment extends Model
{
    use BelongsToUser, HasFactory;

    protected $guarded = [];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => AssignmentDeleted::class,
    ];

    public function assignable()
    {
        return $this->morphTo();
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\AssignmentFactory::new();
    }
}
