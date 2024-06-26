<?php

namespace App\Livewire\Admin\Notifications;

use App\Livewire\Forms\Admin\CreateNotificationForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class CreateNotification extends Component
{
    public CreateNotificationForm $form;

    public function send()
    {
        $this->form->store();
    }

    public function render()
    {
        return view('livewire.admin.notifications.create');
    }
}
