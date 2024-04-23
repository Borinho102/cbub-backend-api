<?php

namespace App\Livewire\Forms\Admin\Business;

use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Country;
use App\Services\Utils\Initials;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

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

    public $owner_name;

    public $owner_email;

    public $owner_phone;

    public $owner_address;

    public $logo;

    public $banners = [];

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
        $this->validate(array_merge($this->getRules(), [
            'email' => 'required|email|unique:businesses,email',
            'banners' => 'nullable|array',
            'banners.*' => 'image|max:5120',
            'logo' => 'required|image|max:5120', // 5MB
            'owner_name' => 'required',
            'owner_email' => 'required|unique:business_users,email',
            'owner_phone' => 'required|unique:business_users,phone',
            'owner_address' => 'nullable|string',
        ]));

        DB::beginTransaction();

        try {
            $business = Business::create([
                ...$this->except('business', 'logo', 'banners', 'owner_name', 'owner_email', 'owner_phone', 'owner_address'),
                'slug' => generateBusinessSlug(
                    Country::select('code')->find($this->country_id)->code,
                    $this->name
                ),
                'initials' => Initials::generate($this->name)
            ]);

            $business
                ->addMedia($this->logo->getRealPath())
                ->usingName($this->logo->getClientOriginalName())
                ->toMediaCollection('logo');

            foreach ($this->banners as $banner) {
                $business
                    ->addMedia($banner->getRealPath())
                    ->usingName($banner->getClientOriginalName())
                    ->toMediaCollection('banners');
            }

            $owner = BusinessUser::create([
                'name' => $this->owner_name,
                'email' => $this->owner_email,
                'phone' => $this->owner_phone,
                'address' => $this->owner_address,
                'city_id' => $this->city_id,
                'country_id' => $this->country_id,
                'password' => bcrypt(Str::random(12)),
                'username' => $this->owner_email,
                'business_id' => $business->id
            ]);

            $owner->syncRoles(['business_owner']);

            DB::commit();

            notify()->success(__('Business successfully created!'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $this->reset();
    }

    public function update()
    {
        $this->validate(array_merge($this->getRules(), [
            'email' => 'required|email|unique:businesses,email,' . $this->business->id . ',id',
            'banners' => 'nullable|array',
            'banners.*' => 'image|max:5120',
            'logo' => 'nullable|image|max:5120' // 5MB
        ]));

        $this->business->update(
            $this->except('logo', 'business', 'banners')
        );

        if (! is_null($this->logo)) {
            $this->business
                ->addMedia($this->logo->getRealPath())
                ->usingName($this->logo->getClientOriginalName())
                ->toMediaCollection('logo');
        }

        notify()->success(__('Business successfully updated!'));
    }
}
