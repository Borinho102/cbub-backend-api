<?php

namespace App\Livewire\Business\Notifications;

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
            ->where('business_id', auth()->user()->business_id)
            ->count();
    }

    public function render()
    {
        return view('livewire.business.notifications.index', [
            'notifications' => BroadcastNotification::query()
                ->with('shop')
                ->where('business_id', auth()->user()->business_id)
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('title->en', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(20)
        ]);
    }
}
