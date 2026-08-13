<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            $this->resetPage();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Notificação marcada como lida',
            ]);
        }
    }

    public function markAllAsRead()
    {
        foreach (Auth::user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Todas marcadas como lidas',
        ]);
    }

    public function refreshNotifications()
    {
        // Método vazio mesmo
        // Serve apenas para forçar o re-render via poll
    }

    public function render()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('livewire.dashboard.notifications-list', [
            'notifications' => $notifications,
        ]);
    }
}
