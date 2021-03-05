<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationCount extends Component
{
    public $count;

    protected $listeners = [
        'NotificationMarkedAsRead' => 'updateCount',
    ];

    public function mount()
    {
        $this->count = Auth::user()->unreadNotifications()->count();
    }

    public function updateCount(int $count): int
    {
        $this->count = $count;
        return $count;
    }

    public function clearNotifications()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->emit('NotificationMarkedAsRead', Auth::user()->unreadNotifications()->count());
    }
    public function render()
    {
        return view('livewire.notification-count');
    }
}
