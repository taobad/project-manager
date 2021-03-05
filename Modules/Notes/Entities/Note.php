<?php

namespace Modules\Notes\Entities;

use App\Traits\BelongsToUser;
use App\Traits\Noteable;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use Noteable, BelongsToUser;

    protected $fillable = ['name', 'description', 'date', 'user_id', 'noteable_type', 'noteable_id'];

    public function noteable()
    {
        return $this->morphTo();
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = Auth::check() ? Auth::id() : $value;
    }

    // public function getDescriptionAttribute($value)
    // {
    //     return EmojiOne::toImage($value);
    // }
}
