<?php

namespace App\Entities;

use App\Traits\Actionable;
use App\Traits\BelongsToUser;
use App\Traits\Commentable;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;

class Phone extends Model
{
    use BelongsToUser, Commentable, Taggable, Actionable;

    protected $fillable = [
        'user_id', 'assignee', 'subject', 'duration', 'scheduled_date', 'type', 'result', 'description', 'cancelled_at',
        'reminder', 'notified_at', 'phoneable_type', 'phoneable_id', 'started_at', 'ended_at', 'recording',
    ];
    protected $table = 'calls';

    protected $dates = [
        'started_at', 'ended_at',
    ];

    public function phoneable()
    {
        return $this->morphTo();
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'assignee', 'id');
    }

    public function commentAlert()
    {
        return;
    }
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = \Auth::id() ?? 1;
    }
    public function setStartedAtAttribute($value)
    {
        $this->attributes['started_at'] = $value > 1 ? dbDate($value, true) : null;
    }
    public function setEndedAtAttribute($value)
    {
        $this->attributes['ended_at'] = $value > 1 ? dbDate($value, true) : null;
    }
}
