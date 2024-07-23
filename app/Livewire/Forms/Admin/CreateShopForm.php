<?php

namespace App\Livewire\Forms\Admin;

use App\Models\BusinessUser;
use App\Models\Country;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;


class CreateShopForm extends Form
{
    use WithFileUploads;

    public ?Shop $shop;

    #[Validate('required|min:5')]
    public $name;

    #[Validate('required|exists:businesses,id', 'business')]
    public $business_id;

    #[Validate('required|exists:world_countries,id', 'country')]
    public $country_id;

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

    public $logo;

    public $image;

    public $banners = [];

    public $schedule = [
        'sunday' => ['', ''],
        'monday' => ['', ''],
        'tuesday' => ['', ''],
        'wednesday' => ['', ''],
        'thursday' => ['', ''],
        'friday' => ['', ''],
        'saturday' => ['', '']
    ];

    public function setShop(Shop $shop)
    {
        $this->shop = $shop;

        $this->name = $shop->name;

        $this->business_id = $shop->business_id;

        $this->country_id = $shop->country_id;

        $this->address = $shop->address;

        $this->email = $shop->email;

        $this->phone = $shop->phone;

        $this->about = $shop->about;

        $this->website = $shop->website;

        $this->facebook = $shop->facebook;

        $this->twitter = $shop->twitter;

        $this->instagram = $shop->instagram;

        $this->linkedin = $shop->linkedin;

        $this->youtube = $shop->youtube;

        $this->schedule = $shop->schedule ? $shop->schedule : [
            'sunday' => ['', ''],
            'monday' => ['', ''],
            'tuesday' => ['', ''],
            'wednesday' => ['', ''],
            'thursday' => ['', ''],
            'friday' => ['', ''],
            'saturday' => ['', '']
        ];
    }

    public function store()
    {
        $this->validate(array_merge($this->getRules(), [
            'email' => 'required|email|unique:shops,email',
            'banners' => 'nullable|array',
            'banners.*' => 'image|max:5120',
            'logo' => 'required|image|max:5120', // 5MB
            'image' => 'required|image|max:5120', // 5MB
        ]));

        DB::beginTransaction();

        try {
            $business_owner = BusinessUser::query()
                ->whereHasRole('business_owner')
                ->where('business_id', $this->business_id)
                ->firstOrFail();

            $shop = Shop::create([
                ...$this->except('shop', 'logo', 'banners', 'image', 'schedule'),
                'owner_id' => $business_owner->id,
                'slug' => generateShopSlug(
                    Country::select('code')->find($this->country_id)->code,
                    $this->name
                )
            ]);

            $shop
                ->addMedia($this->logo->getRealPath())
                ->usingName($this->logo->getClientOriginalName())
                ->toMediaCollection('logo');

            $shop
                ->addMedia($this->image->getRealPath())
                ->usingName($this->image->getClientOriginalName())
                ->toMediaCollection('image');

            foreach ($this->banners as $banner) {
                $shop
                    ->addMedia($banner->getRealPath())
                    ->usingName($banner->getClientOriginalName())
                    ->toMediaCollection('banners');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $this->reset();
    }

    public function update()
    {
        $this->validate(array_merge($this->getRules(), [
            'email' => 'required|email|unique:shops,email,' . $this->shop->id . ',id',
            'banners' => 'nullable|array',
            'banners.*' => 'image|max:5120',
            'logo' => 'nullable|image|max:5120', // 5MB
            'image' => 'nullable|image|max:5120' // 5MB
        ]));

        $business_owner = BusinessUser::query()
            ->whereHasRole('business_owner')
            ->where('business_id', $this->business_id)
            ->firstOrFail();

        $this->shop->update([
            ...$this->except('logo', 'shop', 'banners', 'image'),
            'owner_id' => $business_owner->id
        ]);

        if (! is_null($this->logo)) {
            $this->shop
                ->addMedia($this->logo->getRealPath())
                ->usingName($this->logo->getClientOriginalName())
                ->toMediaCollection('logo');
        }

        if (! is_null($this->image)) {
            $this->shop
                ->addMedia($this->image->getRealPath())
                ->usingName($this->image->getClientOriginalName())
                ->toMediaCollection('image');
        }
    }
}
