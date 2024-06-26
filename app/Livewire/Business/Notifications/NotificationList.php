<?php

namespace App\Livewire\Business\Notifications;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class NotificationList extends Component
{
    public function render()
    {
        return view('livewire.business.notifications.index');
    }
}
