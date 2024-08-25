<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\Admin;
use App\Models\BroadcastNotification;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class NotificationList extends Component
{
    use WithPagination;

    public $count;

    public $query = '';

    public function mount()
    {
        $this->count = BroadcastNotification::query()
            ->where('broadcaster_id', auth()->user()->id)
            ->where('broadcaster_type', Admin::class)
            ->count();
    }

    public function render()
    {
        return view('livewire.admin.notifications.index', [
            'notifications' => BroadcastNotification::query()
                ->where('broadcaster_id', auth()->user()->id)
                ->where('broadcaster_type', Admin::class)
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('title->en', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(20)
        ]);
    }
}
