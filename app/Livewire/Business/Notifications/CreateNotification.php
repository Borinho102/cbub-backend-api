<?php

namespace App\Livewire\Business\Notifications;

use App\Enums\NotificationType;
use App\Jobs\BroadcastNotificationJob;
use App\Livewire\Forms\Business\CreateNotificationForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class CreateNotification extends Component
{
    use WithFileUploads;

    public CreateNotificationForm $form;

    public function send()
    {
        $notification = $this->form->store();

        dispatch(new BroadcastNotificationJob($notification->load('shop')));

        notify()->success(__('Notification successfully created!'));
    }

    public function render()
    {
        return view('livewire.business.notifications.create', [
            'types' => collect(NotificationType::asSelectArray())
                ->transform(function ($name, $id) {
                    return ['id' => $id, 'name' => $name];
                })
        ]);
    }
}
