<?php

namespace App\Livewire\Admin\Businesses;

use App\Livewire\Forms\Admin\Business\CreateBusinessForm;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Country;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.backend.app')]
class EditBusiness extends Component
{
    use WithFileUploads;
    
    public CreateBusinessForm $form;

    public $cities;

    public $countries;

    public $categories;

    public function mount(Business $business)
    {
        $this->form->setBusiness($business);

        $this->countries = Country::select('id', 'name')
            ->active()->get();

        $this->categories = BusinessCategory::select('id', 'name')
            ->get();

        $this->cities = [];
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('admin.businesses.index'));
    }

    public function render()
    {
        return view('livewire.admin.businesses.create');
    }
}
