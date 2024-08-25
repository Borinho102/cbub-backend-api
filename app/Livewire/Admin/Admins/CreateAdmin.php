<?php

namespace App\Livewire\Admin\Admins;

use App\Livewire\Forms\Admin\CreateAdminForm;
use App\Models\City;
use App\Models\Country;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend-app')]
class CreateAdmin extends Component
{
    use WithFileUploads;

    public CreateAdminForm $form;

    public $cities;

    public $countries;

    public $roles;

    public $permissions;

    public function mount()
    {
        $this->countries = Country::select('id', 'name')
            ->active()->get();

        $this->roles = Role::select('id', 'name', 'display_name')
            ->whereIn('name', ['admin', 'owner'])->get();

        $this->permissions = Permission::select('id', 'name', 'display_name')
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['admin', 'owner']);
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

        notify()->success(__('User successfully created!'));

        return $this->redirect(route('admin.admins.index'));
    }

    public function render()
    {
        return view('livewire.admin.admins.create');
    }
}
