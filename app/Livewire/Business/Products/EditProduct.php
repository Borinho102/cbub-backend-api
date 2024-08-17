<?php

namespace App\Livewire\Business\Products;

use App\Livewire\Forms\Business\Product\CreateProductForm;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class EditProduct extends Component
{
    use WithFileUploads;

    public CreateProductForm $form;

    public $productType;

    public bool $showForm;

    public function mount(Product $product)
    {
        $this->showForm = true;

        $this->form->setProduct($product);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('business.products.index'));
    }

    public function render()
    {
        return view('livewire.business.products.create');
    }
}
