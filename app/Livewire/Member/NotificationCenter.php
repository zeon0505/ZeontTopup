<?php

namespace App\Livewire\Member;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationCenter extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    protected $listeners = ['notification-received' => '$refresh'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        if (!$user) return;

        $this->unreadCount = $user->unreadNotifications()->count();
        $this->notifications = $user->notifications()->latest()->take(10)->get();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function render()
    {
        $this->loadNotifications();
        return view('livewire.member.notification-center');
    }
}
