<?php

namespace App\Livewire\Admin\Businesses\Categories;

use App\Livewire\Forms\Admin\Business\Category\CreateCategoryForm;
use App\Models\BusinessCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class EditCategory extends Component
{
    use WithFileUploads;

    public CreateCategoryForm $form;

    public $categories;

    public function mount(BusinessCategory $category)
    {
        $this->form->setCategory($category);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('admin.businesses.categories.index'));
    }

    public function render()
    {
        return view('livewire.admin.businesses.categories.create');
    }
}
