<?php

namespace App\Livewire\Business\Products;

use App\Livewire\Forms\Business\Product\CreateProductForm;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class CreateProduct extends Component
{
    use WithFileUploads;

    public CreateProductForm $form;

    public $productType;

    public bool $showForm;

    public function updatedFormShortDescriptionEn()
    {
        $this->form->short_description_fr = $this->form->short_description_en;
    }

    public function updatedProductType()
    {
        $this->form->type = $this->productType;
    }

    public function updatedFormQuantity()
    {
        if ($this->form->parent_id) {
            $this->form->items_count = $this->form->quantity;
        }
    }

    public function updatedFormParentId()
    {
        $this->form->parent_id = $this->form->parent_id;
        $this->form->setParentProduct(Product::find($this->form->parent_id));
    }

    public function updatedFormDescriptionEn()
    {
        $this->form->description_fr = $this->form->description_en;
    }

    public function updatedFormNameEn()
    {
        $this->form->name_fr = $this->form->name_en;
    }

    public function showForm()
    {
        $this->showForm = true;
    }

    public function selectProductType($type)
    {
        $this->productType = $type;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('business.products.index'));
    }

    public function render()
    {
        return view('livewire.business.products.create');
    }
}
