<?php

namespace App\Livewire\Business\Shops;

use App\Livewire\Forms\Business\CreateShopForm;
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

        return $this->redirect(route('business.shops.index'));
    }

    public function render()
    {
        return view('livewire.business.shops.create');
    }
}
