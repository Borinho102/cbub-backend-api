<?php

namespace App\Livewire\Admin\Shops;

use App\Livewire\Forms\Admin\CreateShopForm;
use App\Models\Shop;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend-app')]
class EditShop extends Component
{
    use WithFileUploads;

    public CreateShopForm $form;


    public function mount(Shop $shop)
    {
        $this->form->setShop($shop);
    }

    public function save()
    {
        $this->form->update();

        notify()->success(__('Shop successfully updated!'));

        return $this->redirect(route('admin.shops.index'));
    }

    public function render()
    {
        return view('livewire.admin.shops.create');
    }
}
