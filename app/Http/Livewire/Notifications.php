<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Notifications extends Component
{
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

    public function render(): View
    {
        return view('livewire.notifications', [
            'notifications' => Auth::user()->unreadNotifications()->paginate(10),
        ]);
    }
}
