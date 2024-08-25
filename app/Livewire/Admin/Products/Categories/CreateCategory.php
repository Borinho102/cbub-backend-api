<?php

namespace App\Livewire\Admin\Products\Categories;

use App\Livewire\Forms\Admin\Product\CreateProductCategoryForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend-app')]
class CreateCategory extends Component
{
    use WithFileUploads;

    public CreateProductCategoryForm $form;

    public function updatedFormNameEn()
    {
        $this->form->name_fr = $this->form->name_en;
    }

    public function save()
    {
        $this->form->store();

        notify()->success(__('Product category successfully created!'));

        return $this->redirect(route('admin.products.categories.index'));
    }

    public function render()
    {
        return view('livewire.admin.products.categories.create');
    }
}
