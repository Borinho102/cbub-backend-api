<?php

namespace App\Livewire\Admin\Products;

use App\Enums\ProductTagType;
use App\Livewire\Forms\Admin\Product\CreateProductForm;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class EditProduct extends Component
{
    use WithFileUploads;

    public CreateProductForm $form;

    public $tagOptions;

    public function mount(Product $product)
    {
        $this->form->setProduct($product);

        $this->tagOptions = ProductTagType::asSelectArray();
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('admin.products.index'));
    }

    public function render()
    {
        return view('livewire.admin.products.create');
    }
}
