<?php

namespace App\Livewire\Forms\Admin;

use App\Models\BroadcastNotification;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateNotificationForm extends Form
{
    use WithFileUploads;

    #[Validate('required|min:4')]
    public $title_en;

    #[Validate('required|min:4')]
    public $title_fr;

    #[Validate('required|min:4')]
    public $body_en;

    #[Validate('required|min:4')]
    public $body_fr;

    #[Validate('nullable|date')]
    public $broadcast_at;

    #[Validate('nullable|required_with:image_fr|image|max:2048')] // 2MB Max
    public $image_en;

    #[Validate('nullable|required_with:image_en|image|max:2048')] // 2MB Max
    public $image_fr;

    #[Validate('nullable|exists:users,id')]
    public $users = [];

    public function store()
    {
        $this->validate();

        $images = [];
        if ($this->image_en) {
            $path_en = $this->image_en->storePubliclyAs('notifications/images', now()->timestamp . '_en.' . $this->image_en->getClientOriginalExtension());
            $path_fr = $this->image_fr->storePubliclyAs('notifications/images', now()->timestamp . '_fr.' . $this->image_fr->getClientOriginalExtension());
            $images = [
                'en' => $path_en,
                'fr' => $path_fr
            ];
        }

        $user = auth()->user();
        $data = [];
        if (!empty($this->users)) {
            $data['users'] = $this->users;
        }

        $notification = BroadcastNotification::create([
            'title' => [
                'en' => $this->title_en,
                'fr' => $this->title_fr
            ],
            'body' => [
                'en' => $this->body_en,
                'fr' => $this->body_fr
            ],
            'image' => !empty($images) ? $images : null,
            'data' => $data,
            'broadcast_at' => $this->broadcast_at,
            'broadcaster_id' => $user->id,
            'broadcaster_type' => get_class($user)
        ]);

        $this->reset();

        return $notification;
    }
}
