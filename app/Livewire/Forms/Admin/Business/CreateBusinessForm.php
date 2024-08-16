<?php

namespace App\Livewire\Forms\Admin\Business;

use App\Models\Admin;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Country;
use App\Models\Invitation;
use App\Notifications\BusinessInvitation;
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

    #[Validate('required')]
    public $phone;

    #[Validate('required')]
    public $address;

    public $email;

    #[Validate('nullable|max:500')]
    public $about;

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

        $this->address = $business->address;

        $this->email = $business->email;

        $this->phone = $business->phone;

        $this->about = $business->about;
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
                )
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
                'country_id' => $this->country_id,
                'password' => bcrypt(Str::random(12)),
                'username' => generateUsername(new BusinessUser, explode('@', $this->owner_email)[0]),
                'business_id' => $business->id
            ]);

            $owner->syncRoles(['business_owner']);

            $invitation = Invitation::create([
                'invitee_id' => $owner->id,
                'invitee_type' => get_class($owner),
                'invitor_id' => auth('admins')->user()->id,
                'invitor_type' => Admin::class,
                'expires_at' => now()->addDays(2),
                'token' => Str::random(64)
            ]);

            DB::commit();

            $owner->notify(new BusinessInvitation($invitation));

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
