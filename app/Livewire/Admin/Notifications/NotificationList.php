<?php

namespace App\Livewire\Admin\Notifications;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class NotificationList extends Component
{
    public function render()
    {
        return view('livewire.admin.notifications.index');
    }
}
