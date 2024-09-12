<?php

namespace App\Livewire\Business;

use App\Livewire\Forms\Business\ChangePasswordForm;
use App\Livewire\Forms\Business\UpdateProfileForm;
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

        return view('livewire.business.settings', [
            'menu' => $this->menu
        ]);
    }

    public function updateProfile()
    {
        $this->profileForm->update();

        return redirect(route('business.settings', $this->menu));
    }

    public function updatePassword()
    {
        $this->passwordForm->change();

        return redirect(route('business.settings', $this->menu));
    }
}
