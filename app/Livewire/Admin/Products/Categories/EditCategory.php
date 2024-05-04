<?php

namespace App\Livewire\Admin\Products\Categories;

use App\Enums\ProductTagType;
use App\Livewire\Forms\Admin\Product\CreateProductCategoryForm;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class EditCategory extends Component
{
    use WithFileUploads;

    public CreateProductCategoryForm $form;

    public $categories;

    public $tagOptions;

    public function mount(ProductCategory $category)
    {
        $this->form->setCategory($category);

        $this->categories = ProductCategory::select('id', 'name')
            ->whereNull('parent_id')->get();

        $this->tagOptions = ProductTagType::asSelectArray();
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('admin.products.categories.index'));
    }

    public function render()
    {
        return view('livewire.admin.products.categories.create');
    }
}
