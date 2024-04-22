<?php

namespace App\Livewire\Admin\Admins;

use App\Livewire\Forms\Admin\CreateAdminForm;
use App\Models\Admin;
use App\Models\Business;
use App\Models\City;
use App\Models\Country;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class EditAdmin extends Component
{
    use WithFileUploads;

    public CreateAdminForm $form;

    public $cities;

    public $countries;

    public $roles;

    public $permissions;

    public function mount(Admin $admin)
    {
        $this->form->setAdmin($admin);

        $this->countries = Country::select('id', 'name')
            ->active()->get();

        $this->roles = Role::select('id', 'name', 'display_name')->get();

        $this->permissions = Permission::select('id', 'name', 'display_name')
            ->whereRoleIs(['admin', 'owner'])->get();

        $this->updatedFormCountryId();
    }

    public function updatedFormCountryId()
    {
        $this->cities = City::select('id', 'name')
            ->where('country_id', $this->form->country_id)
            ->get();
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('admin.admins.index'));
    }

    public function render()
    {
        return view('livewire.admin.admins.create');
    }
}
