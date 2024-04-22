<?php

namespace App\Livewire\Admin\PromoCodes;

use App\Livewire\Forms\Admin\CreatePromoCodeForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class CreatePromoCode extends Component
{
    use WithFileUploads;

    public CreatePromoCodeForm $form;

    public $activeTab;

    public function mount()
    {
        $this->activeTab = 'general';
    }

    public function updatedFormCode($value)
    {
        $this->form->code = strtoupper(str()->replace(' ','', $value));
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('admin.promo_codes.index'));
    }

    public function render()
    {
        return view('livewire.admin.promo_codes.create');
    }
}
