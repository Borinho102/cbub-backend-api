<?php

namespace App\Livewire\Business\Products;

use App\Enums\ProductType;
use App\Livewire\Forms\Business\Product\CreateProductForm;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend-app')]
class CreateProduct extends Component
{
    use WithFileUploads;

    public CreateProductForm $form;

    public $productType;

    public bool $showForm;

    public function mount()
    {
        $this->productType = ProductType::Physical;

        $this->showForm = true;
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
