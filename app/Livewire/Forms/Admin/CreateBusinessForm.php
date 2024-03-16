<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Business;
use App\Models\Country;
use App\Services\Utils\Initials;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateBusinessForm extends Form
{
    use WithFileUploads;

    public ?Business $business;

    #[Validate('required|min:5')]
    public $name;

    #[Validate('required', 'category')]
    public $category_id;

    #[Validate('required|exists:world_countries,id', 'country')]
    public $country_id;

    #[Validate('required|exists:world_cities,id', 'city')]
    public $city_id;

    #[Validate('required')]
    public $phone;

    #[Validate('required')]
    public $address;

    #[Validate('required|email|unique:businesses,email')]
    public $email;

    #[Validate('nullable|max:500')]
    public $about;

    #[Validate('nullable|url')]
    public $website;

    #[Validate('nullable|url')]
    public $facebook;

    #[Validate('nullable|url')]
    public $twitter;

    #[Validate('nullable|url')]
    public $instagram;

    #[Validate('nullable|url')]
    public $linkedin;

    #[Validate('nullable|url')]
    public $youtube;

    #[Validate('required|image|max:5120')] // 5MB Max
    public $logo;

    public function setBusiness(Business $business)
    {
        $this->business = $business;

        $this->name = $business->name;

        $this->category_id = $business->category_id;

        $this->country_id = $business->country_id;

        $this->city_id = $business->city_id;

        $this->address = $business->address;

        $this->email = $business->email;

        $this->phone = $business->phone;

        $this->about = $business->about;

        $this->website = $business->website;

        $this->facebook = $business->facebook;

        $this->twitter = $business->twitter;

        $this->instagram = $business->instagram;

        $this->linkedin = $business->linkedin;

        $this->youtube = $business->youtube;
    }

    public function store()
    {
        $this->validate();

        $business = Business::create([
            ...$this->except('business'),
            'slug' => generateBusinessSlug(
                Country::select('code')->find($this->country_id)->code,
                $this->name
            ),
            'initials' => Initials::generate($this->name)
        ]);

        $business->addMedia($this->logo);

        $this->reset();
    }

    public function update()
    {
        $this->business->update($this->all());
    }
}
