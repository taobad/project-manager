<?php

namespace App\Traits;

use App\Entities\Chat;

trait Chatable
{
    public function chats()
    {
        return $this->morphMany(Chat::class, 'chatable')->with('user:id,username,name')->orderByDesc('id');
    }
}
