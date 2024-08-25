<?php

namespace App\Livewire\Business\Customers;

use App\Livewire\Forms\Business\CreateCustomerForm;
use App\Models\City;
use App\Models\Country;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend-app')]
class CreateCustomer extends Component
{
    use WithFileUploads;

    public CreateCustomerForm $form;

    public $cities;

    public $countries;

    public $roles;

    public $permissions;

    public function mount()
    {
        $this->countries = Country::select('id', 'name')
            ->active()->get();

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

        notify()->success(__('Customer successfully created!'));

        return $this->redirect(route('business.customers.index'));
    }

    public function render()
    {
        return view('livewire.business.customers.create');
    }
}
