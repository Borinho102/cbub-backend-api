<?php

namespace App\Livewire\Admin\PromoCodes;

use App\Livewire\Forms\Admin\PromoCode\CreatePromoCodeForm;
use App\Models\PromoCode;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.backend.app')]
class EditPromoCode extends Component
{
    use WithFileUploads;

    public CreatePromoCodeForm $form;

    public $activeTab;

    public function mount(int $promo_code)
    {
        $promoCode = PromoCode::with('users', 'products', 'categories')->findOrFail($promo_code);
        
        $this->activeTab = 'general';

        $this->form->setPromoCode($promoCode);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect(route('admin.promo_codes.index'));
    }

    public function render()
    {
        return view('livewire.admin.promo_codes.create');
    }
}
