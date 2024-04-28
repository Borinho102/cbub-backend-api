<?php

namespace App\Livewire\Admin\Businesses;

use App\Livewire\Forms\Admin\Business\CreateBusinessForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class EditBusiness extends Component
{
    use WithFileUploads;

    public CreateBusinessForm $form;

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('admin.businesses.index'));
    }

    public function render()
    {
        return view('livewire.admin.businesses.create');
    }
}
