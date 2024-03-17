<?php

namespace App\Livewire\Admin\Products;

use App\Livewire\Forms\Admin\Product\CreateProductForm;
use App\Models\Business;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.backend.app')]
class CreateProduct extends Component
{
    use WithFileUploads;

    public CreateProductForm $form;

    public $businesses;

    public $categories;

    public function mount() {
        $this->businesses = Business::select('id', 'name', 'country_id')
            ->with('country')
            ->get();

        $this->categories = ProductCategory::select('id', 'name')
            ->where('is_active', 1)->get();
    }

    public function updatedFormShortDescriptionEn()
    {
        $this->form->short_description_fr = $this->form->short_description_en;
    }

    public function updatedFormDescriptionEn()
    {
        $this->form->description_fr = $this->form->description_en;
    }

    public function updatedFormNameEn()
    {
        $this->form->name_fr = $this->form->name_en;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('admin.products.index'));
    }

    public function render()
    {
        return view('livewire.admin.products.create');
    }
}
