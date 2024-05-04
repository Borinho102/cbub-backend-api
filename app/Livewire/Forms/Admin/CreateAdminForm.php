<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Admin;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;

class CreateAdminForm extends Form
{
    public ?Admin $admin;

    #[Validate('required|min:4|unique:promo_codes,code')]
    public $name;

    #[Validate('required|email')]
    public $email;

    #[Validate('required')]
    public $phone;

    #[Validate('nullable|string')]
    public $address;

    #[Validate('required|exists:world_countries,id')]
    public $country_id;

    #[Validate('required|exists:world_cities,id')]
    public $city_id;

    #[Validate('required|array')]
    public $roles = [];

    #[Validate('nullable|array')]
    public $permissions = [];

    #[Validate('nullable|image')]
    public $profile_picture;

    public function setAdmin(Admin $admin)
    {
        $this->admin = $admin;

        $this->name = $admin->name;

        $this->email = $admin->email;

        $this->phone = $admin->phone;

        $this->address = $admin->address;

        $this->country_id = $admin->country_id;

        $this->city_id = $admin->city_id;

        $this->roles = $admin->roles->pluck('id');

        $this->permissions = $admin->permissions->pluck('id');
    }

    public function store()
    {
        $this->validate();

        $admin = Admin::create([
            ...$this->except('admin', 'permissions', 'roles'),
            'username' => generateUsername(new Admin, explode('@', $this->email)[0]),
            'password' => bcrypt(Str::random(10))
        ]);

        $admin->syncRoles($this->roles);

        if (!empty($this->permissions)) {
            $admin->syncPermissions($this->permissions);
        }

        if ($this->profile_picture) {
            $admin
                ->addMedia($this->profile_picture->getRealPath())
                ->usingName($this->profile_picture->getClientOriginalName())
                ->toMediaCollection('avatar');
        }

        $this->reset();

        notify()->success(__('User successfully created!'));
    }

    public function update()
    {
        $this->validate();
        //
        notify()->success(__('User successfully updated!'));
    }
}
