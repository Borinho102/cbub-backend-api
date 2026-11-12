<?php

namespace App\Livewire\Forms\Business;

use App\Models\BusinessUser;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;

class CreateUserForm extends Form
{
    public ?BusinessUser $user;

    #[Validate('required|min:4')]
    public $name;

    #[Validate('required|email')]
    public $email;

    #[Validate('required')]
    public $phone;

    #[Validate('nullable|string')]
    public $address;

    #[Validate('required|array')]
    public $roles = [];

    #[Validate('required|array')]
    public $shops = [];

    #[Validate('nullable|array')]
    public $permissions = [];

    #[Validate('nullable|image')]
    public $profile_picture;

    public function setUser(BusinessUser $user)
    {
        $this->user = $user;

        $this->name = $user->name;

        $this->email = $user->email;

        $this->phone = $user->phone;

        $this->address = $user->address;

        $this->roles = $user->roles->pluck('id');

        $this->shops = $user->shops->pluck('id');

        $this->permissions = $user->permissions->pluck('id');
    }

    public function store()
    {
        $this->validate();

        $authUser = auth()->user();

        $user = BusinessUser::create([
            ...$this->except('user', 'permissions', 'roles', 'shops', 'profile_picture'),
            'business_id' => $authUser->business_id,
            'city_id' => $authUser->city_id,
            'country_id' => $authUser->country_id,
            'username' => generateUsername(new BusinessUser, explode('@', $this->email)[0]),
            'password' => bcrypt(Str::random(10))
        ]);

        $user->syncRoles($this->roles);

        if (!empty($this->permissions)) {
            $user->syncPermissions($this->permissions);
        }

        if ($this->profile_picture) {
            $user
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
