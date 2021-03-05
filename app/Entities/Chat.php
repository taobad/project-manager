<?php

namespace App\Entities;

use App\Traits\BelongsToUser;
use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use BelongsToUser, Uploadable;

    protected $fillable = [
        'user_id', 'inbound', 'platform', 'message', 'from', 'to', 'delivered', 'read', 'meta', 'is_sms',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function chatable()
    {
        return $this->morphTo();
    }

    public function markRead()
    {
        if ($this->read == 0) {
            $this->update(['read' => 1]);
            $this->chatable->update(['has_chats' => 0]);
        }
    }
    public function isDelivered()
    {
        return $this->update(['delivered' => 1]);
    }

    public function scopeUnread($query)
    {
        return $query->whereRead(0);
    }

    public function scopeSms($query)
    {
        return $query->where('is_sms', 1);
    }

    public function scopeWhatsapp($query)
    {
        return $query->where('is_sms', 0);
    }
}
