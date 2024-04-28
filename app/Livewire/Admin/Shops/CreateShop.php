<?php

namespace App\Livewire\Admin\Shops;

use App\Livewire\Forms\Admin\CreateShopForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class CreateShop extends Component
{
    use WithFileUploads;

    public CreateShopForm $form;

    public function save()
    {
        $this->form->store();

        notify()->success(__('Shop successfully created!'));

        return $this->redirect(route('admin.shops.index'));
    }

    public function render()
    {
        return view('livewire.admin.shops.create');
    }
}
