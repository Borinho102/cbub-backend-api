<?php

namespace App\Livewire\Admin\Notifications;

use App\Jobs\BroadcastNotificationJob;
use App\Livewire\Forms\Admin\CreateNotificationForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class CreateNotification extends Component
{
    public CreateNotificationForm $form;

    public function send()
    {
        $notification = $this->form->store();

        dispatch(new BroadcastNotificationJob($notification->load('shop')));

        notify()->success(__('Notification successfully created!'));

        return $this->redirect(route('admin.notifications.index'));
    }

    public function render()
    {
        return view('livewire.admin.notifications.create');
    }
}
