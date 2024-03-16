<?php

namespace App\Livewire\Admin\Businesses;

use App\Livewire\Forms\Admin\CreateBusinessForm;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Country;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class EditBusiness extends Component
{
    public CreateBusinessForm $form;

    public function mount(Business $business)
    {
        $this->form->setBusiness($business);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('admin.businesses.index'));
    }

    public function render()
    {
        return view('livewire.admin.businesses.create')
            ->with([
                'categories' => BusinessCategory::select('id', 'name')->get(),
                'countries' => Country::select('id', 'name')
                    ->active()->get(),
                'cities' => collect()
            ]);
    }
}
