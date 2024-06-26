<?php

namespace App\Livewire\Forms\Business;

use App\Models\BroadcastNotification;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateNotificationForm extends Form
{
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

    #[Validate('required_with:image_fr|image|max:2048')] // 2MB Max
    public $image_en;

    #[Validate('required_with:image_en|image|max:2048')] // 2MB Max
    public $image_fr;

    #[Validate('nullable|exists:users,id')]
    public $users = [];

    public function store() : BroadcastNotification
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
            'data' => !empty($this->users) ? [
                'users' => $this->users
            ] : null,
            'broadcast_at' => $this->broadcast_at,
            'business_id' => $user->business_id,
            'broadcaster_id' => $user->id,
            'broadcaster_type' => get_class($user)
        ]);

        $this->reset();

        return $notification;
    }
}
