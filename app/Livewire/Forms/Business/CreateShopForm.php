<?php

namespace App\Livewire\Forms\Business;

use App\Models\BusinessUser;
use App\Models\Country;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use MatanYadaev\EloquentSpatial\Objects\Point;

class CreateShopForm extends Form
{
    use WithFileUploads;

    public ?Shop $shop;

    #[Validate('required|min:5')]
    public $name;

    #[Validate('required|exists:world_countries,id', 'country')]
    public $country_id;

    #[Validate('required')]
    public $phone;

    #[Validate('required')]
    public $address;

    public $email;

    #[Validate('nullable|max:500')]
    public $about;

    #[Validate('required_with:longitude|numeric')]
    public $latitude;

    #[Validate('required_with:latitude|numeric')]
    public $longitude;

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
        'sunday' => [null, null],
        'monday' => [null, null],
        'tuesday' => [null, null],
        'wednesday' => [null, null],
        'thursday' => [null, null],
        'friday' => [null, null],
        'saturday' => [null, null]
    ];

    public function setShop(Shop $shop)
    {
        $this->shop = $shop;

        $this->name = $shop->name;

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

        $this->schedule = $shop->schedule ?
            collect($shop->schedule)
                ->filter(function ($v) {
                    return isset($v[0]) && count(explode('-', $v[0])) == 2;
                })
                ->map(function ($v) {
                    $parts = explode('-', $v[0]);
                    $v = [$parts[0], $parts[1]];
                    return $v;
                }) :
            [
                'sunday' => [null, null],
                'monday' => [null, null],
                'tuesday' => [null, null],
                'wednesday' => [null, null],
                'thursday' => [null, null],
                'friday' => [null, null],
                'saturday' => [null, null]
            ];
    }

    public function store()
    {
        $this->validate(array_merge($this->getRules(), [
            'email' => 'required|email|unique:shops,email',
            'banners' => 'nullable|array',
            'banners.*' => 'image|max:5120',
            'schedule' => 'nullable|array',
            'logo' => 'required|image|max:5120', // 5MB
            'image' => 'required|image|max:5120', // 5MB
        ]));

        $user = auth()->user();

        DB::beginTransaction();

        try {
            $business_owner = BusinessUser::query()
                ->whereHasRole('business_owner')
                ->where('business_id', $user->business_id)
                ->firstOrFail();

            $schedule = collect($this->schedule)
                ->filter(fn ($v, $k) => !empty($v[0]) && !empty($v[1]) && ($v[0] !== '00:00:00' || $v[1] !== '00:00:00'))
                ->map(fn ($v, $k) => $v = [$v[0] . '-' . $v[1]]);

            $shop = Shop::create([
                ...$this->except('shop', 'logo', 'banners', 'image', 'latitute', 'longitude', 'schedule'),
                'owner_id' => $business_owner->id,
                'business_id' => $user->business_id,
                'schedule' => $schedule->isNotEmpty() ? $schedule : null,
                'slug' => generateShopSlug(
                    Country::select('code')->find($this->country_id)->code,
                    $this->name
                ),
                'location' => $this->latitude ?
                    new Point($this->latitude, $this->longitude) : null,
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
            'schedule' => 'nullable|array',
            'logo' => 'nullable|image|max:5120', // 5MB
            'image' => 'nullable|image|max:5120' // 5MB
        ]));

        $user = auth()->user();

        $business_owner = BusinessUser::query()
            ->whereHasRole('business_owner')
            ->where('business_id', $user->business_id)
            ->firstOrFail();

        $schedule = collect($this->schedule)
            ->filter(fn ($v, $k) => !empty($v[0]) && !empty($v[1]) && ($v[0] !== '00:00:00' || $v[1] !== '00:00:00'))
            ->map(fn ($v, $k) => $v = [$v[0] . '-' . $v[1]]);

        $this->shop->update([
            ...$this->except('logo', 'shop', 'banners', 'image', 'latitute', 'longitude', 'schedule'),
            'schedule' => $schedule->isNotEmpty() ? $schedule : null,
            'owner_id' => $business_owner->id,
            'location' => $this->latitude ?
                new Point($this->latitude, $this->longitude) : null,
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
