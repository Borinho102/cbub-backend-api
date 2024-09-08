<?php

namespace App\Livewire\Forms\Business;

use App\Models\BusinessUser;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateProfileForm extends Form
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $phone;

    #[Validate('nullable|image')]
    public $profile_picture;

    #[Validate(['required', 'string', 'lowercase', 'email', 'max:255'])]
    public $email;

    public function setProfile() {
        $user = request()->user('business');

        $this->email = $this->email ?: $user->email;
        $this->phone = $this->phone ?: $user->phone;
        $this->name = $this->name ?: $user->name;
    }

    public function update()
    {
        $this->validate(array_merge($this->getRules(), [
            'email' => 'required|email|string|lowercase|max:255|' . Rule::unique(BusinessUser::class)->ignore(request()->user('business')->id),
        ]));

        $this->validate();

        $user = request()->user('business');

        $user->fill($this->except('profile_picture'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($this->profile_picture) {
            $user
                ->addMedia($this->profile_picture->getRealPath())
                ->usingName($this->profile_picture->getClientOriginalName())
                ->toMediaCollection('avatar');
        }

        $user->save();

        notify()->success(__('Profile successfully updated!'));
    }
}
