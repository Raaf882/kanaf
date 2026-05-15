<?php

namespace App\Livewire\Shared;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationBell extends Component
{
    public bool $open = false;

    public function getNotificationsProperty()
    {
        return Auth::user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get();
    }

    public function getUnreadCountProperty(): int
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function markAllRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function markRead(string $id): void
    {
        Auth::user()->notifications()->where('id', $id)->first()?->markAsRead();
    }

    public function render()
    {
        return view('livewire.shared.notification-bell');
    }
}
