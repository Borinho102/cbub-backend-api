<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\ChangePasswordForm;
use App\Livewire\Forms\Admin\UpdateProfileForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend-app')]
class Settings extends Component
{
    use WithFileUploads;

    public ChangePasswordForm $passwordForm;

    public UpdateProfileForm $profileForm;

    public string $menu;

    public function mount(string $menu)
    {
        $this->menu = $menu;
    }

    public function render()
    {
        if ($this->menu === 'profile') {
            $this->profileForm->setProfile();
        }

        return view('livewire.admin.settings', [
            'menu' => $this->menu
        ]);
    }

    public function updateProfile()
    {
        $this->profileForm->update();

        return redirect(route('admin.settings', $this->menu));
    }

    public function updatePassword()
    {
        $this->passwordForm->change();

        return redirect(route('admin.settings', $this->menu));
    }
}
