<?php

namespace App\Livewire\Admin\Businesses\Categories;

use App\Livewire\Forms\Admin\Business\CreateCategoryForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class CreateCategory extends Component
{
    use WithFileUploads;

    public CreateCategoryForm $form;

    public function updatedFormNameEn()
    {
        $this->form->code = generateBusinessCategoryCode(
            $this->form->name_en
        );
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('admin.businesses.categories.index'));
    }

    public function render()
    {
        return view('livewire.admin.businesses.categories.create');
    }
}
