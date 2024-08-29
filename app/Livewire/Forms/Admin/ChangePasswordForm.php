<?php

namespace App\Livewire\Forms\Admin;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ChangePasswordForm extends Form
{
    #[Validate('required|current_password')]
    public $current_password;

    #[Validate(['required', 'min:8', 'confirmed'])]
    public $password;

    public function change()
    {
        $this->validate();

        request()->user('admins')->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset();

        notify()->success(__('Password successfully updated!'));
    }
}
