<?php

namespace App\Livewire\Admin\Products;

use App\Enums\ProductTagType;
use App\Livewire\Forms\Admin\Product\CreateProductForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class CreateProduct extends Component
{
    use WithFileUploads;

    public CreateProductForm $form;

    public $tagOptions;

    public function mount() {
        $this->tagOptions = ProductTagType::asSelectArray();
    }

    public function updatedFormShortDescriptionEn()
    {
        $this->form->short_description_fr = $this->form->short_description_en;
    }

    public function updatedFormDescriptionEn()
    {
        $this->form->description_fr = $this->form->description_en;
    }

    public function updatedFormNameEn()
    {
        $this->form->name_fr = $this->form->name_en;
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('admin.products.index'));
    }

    public function render()
    {
        return view('livewire.admin.products.create');
    }
}
