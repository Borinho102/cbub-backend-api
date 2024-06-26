<?php

namespace App\Livewire\Forms\Admin;

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

    #[Validate('nullable|image|max:2048')] // 2MB Max
    public $image;

    #[Validate('nullable|exists:users,id')]
    public $users = [];

    public function store()
    {
        $this->validate();

        // if ($this->image) {
        //     $category
        //         ->addMedia($this->image->getRealPath())
        //         ->usingName($this->image->getClientOriginalName())
        //         ->toMediaCollection('image');
        // }

        $this->reset();
    }
}
