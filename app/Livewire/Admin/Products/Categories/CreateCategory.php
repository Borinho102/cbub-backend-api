<?php

namespace App\Livewire\Admin\Products\Categories;

use App\Livewire\Forms\Admin\Product\Category\CreateCategoryForm;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.backend.app')]
class CreateCategory extends Component
{
    use WithFileUploads;

    public CreateCategoryForm $form;

    public $categories;

    public function mount()
    {
        $this->categories = ProductCategory::select('id', 'name')
            ->whereNull('parent_id')->get();
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
