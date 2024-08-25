<?php

namespace App\Livewire\Business\Products\Categories;

use App\Livewire\Forms\Business\Product\CreateProductCategoryForm;
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
        $this->form->code = generateProductCategoryCode(
            $this->form->name_en
        );
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('business.products.categories.index'));
    }

    public function render()
    {
        return view('livewire.business.products.categories.create');
    }
}
