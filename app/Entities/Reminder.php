<?php

namespace App\Entities;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;

class Reminder extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id', 'recipient_id', 'description', 'reminder_date', 'send_email', 'remindable_type',
        'remindable_id', 'reminded_at',
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function remindable()
    {
        return $this->morphTo();
    }
    public function scopeReminderAlerts($query)
    {
        return $query->whereBetween('reminder_date', [now()->subMinutes(5), now()->addMinutes(5)])->whereNull('reminded_at');
    }

    public function setReminderDateAttribute($value)
    {
        $this->attributes['reminder_date'] = dbDate($value, true);
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = \Auth::id();
    }
}
