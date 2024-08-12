<?php

namespace App\Livewire\Forms\Business;

use App\Enums\NotificationType;
use App\Models\BroadcastNotification;
use BenSampo\Enum\Rules\EnumValue;
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

    #[Validate('nullable|required_with:image_fr|image|max:2048')] // 2MB Max
    public $image_en;

    #[Validate('nullable|required_with:image_en|image|max:2048')] // 2MB Max
    public $image_fr;

    #[Validate('nullable|exists:users,id')]
    public $users = [];

    #[Validate('nullable|exists:shops,id')]
    public $shop;

    #[Validate('nullable|exists:products,id')]
    public $product;

    #[Validate('nullable|exists:promo_codes,id')]
    public $promo_code;

    #[Validate('required|' . new EnumValue(NotificationType::class))]
    public $type = NotificationType::Default;

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
        $data = [];
        if (!empty($this->users)) {
            $data['users'] = $this->users;
        }

        if (isset($this->product)) {
            $data['product_id'] = $this->product;
        }

        if (isset($this->promo_code)) {
            $data['promo_code_id'] = $this->promo_code;
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
            'business_id' => $user->business_id,
            'shop_id' => $this->shop,
            'broadcaster_id' => $user->id,
            'broadcaster_type' => get_class($user),
            'type' => $this->type
        ]);

        $this->reset();

        return $notification;
    }
}
