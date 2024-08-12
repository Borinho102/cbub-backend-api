<?php

namespace App\Livewire\Forms\Business;

use App\Models\Customer;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;

class CreateCustomerForm extends Form
{
    #[Validate('required')]
    public $name;

    #[Validate('required|email|unique:users,email')]
    public $email;

    #[Validate('nullable|unique:users,phone')]
    public $phone;

    #[Validate('nullable|string')]
    public $address;

    #[Validate('required|exists:world_countries,id', 'country')]
    public $country_id;

    #[Validate('required|exists:world_cities,id')]
    public $city_id;

    public function store()
    {
        $this->validate();

        $user = User::create([
            ...$this->all(),
            'username' => generateUsername(new User, explode('@', $this->email)[0]),
            'password' => bcrypt(Str::random(10))
        ]);

        Customer::create([
            'user_id' => $user->id,
            'business_id' => auth()->user()->business_id
        ]);

        $this->reset();
    }
}
