<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LatestNotifications extends Component
{
    use WithPagination;

    public $notificationId;

    public function markAsRead(string $notificationId)
    {
        $this->notificationId = $notificationId;
        Auth::user()->unreadNotifications->map(function ($n) use ($notificationId) {
            if ($n->id == $notificationId) {
                $n->markAsRead();
            }
        });
        $this->emit('NotificationMarkedAsRead', Auth::user()->unreadNotifications()->count());
    }
    public function render()
    {
        return view('livewire.latest-notifications', [
            'notifications' => Auth::user()->notifications()->paginate(50),
        ]);
    }
}
