<?php

namespace App\Livewire\Admin\Products\Categories;

use App\Enums\ProductTagType;
use App\Livewire\Forms\Admin\Product\CreateProductCategoryForm;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class CreateCategory extends Component
{
    use WithFileUploads;

    public CreateProductCategoryForm $form;

    public $tagOptions;

    public function mount()
    {
        $this->tagOptions = ProductTagType::asSelectArray();
    }

    public function updatedFormNameEn()
    {
        $this->form->code = generateProductCategoryCode(
            $this->form->name_en
        );
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('admin.products.categories.index'));
    }

    public function render()
    {
        return view('livewire.admin.products.categories.create');
    }
}
