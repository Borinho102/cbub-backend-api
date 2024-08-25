<?php

namespace App\Livewire\Business\Users;

use App\Livewire\Forms\Business\CreateUserForm;
use App\Models\City;
use App\Models\Country;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend-app')]
class CreateUser extends Component
{
    use WithFileUploads;

    public CreateUserForm $form;

    public $cities;

    public $countries;

    public $roles;

    public $permissions;

    public function mount()
    {
        $this->countries = Country::select('id', 'name')
            ->active()->get();

        $this->roles = Role::select('id', 'name', 'display_name')
            ->whereIn('name', ['business_admin', 'business_owner', 'business_member'])->get();

        $this->permissions = Permission::select('id', 'name', 'display_name')
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['business_admin', 'business_owner', 'business_member']);
            })->get();

        $this->cities = [];
    }

    public function updatedFormCountryId()
    {
        $this->cities = City::select('id', 'name')
            ->where('country_id', $this->form->country_id)
            ->get();
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('business.users.index'));
    }

    public function render()
    {
        return view('livewire.business.users.create');
    }
}
