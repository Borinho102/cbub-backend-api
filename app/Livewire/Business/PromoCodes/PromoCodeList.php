<?php

namespace App\Livewire\Business\PromoCodes;

use App\Models\PromoCode;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class PromoCodeList extends Component
{
    use WithPagination;

    public $query = '';

    private $category;

    public function search()
    {
        $this->resetPage();
    }

    public function toggleStatus(PromoCode $promoCode)
    {
        $promoCode->update(['is_active' => !$promoCode->is_active]);

        notify()->success(__('Promo code successfully toggled!'));
    }

    public function render()
    {
        return view('livewire.business.promo_codes.index', [
            'promo_codes' => PromoCode::query()
                ->withCount('users', 'categories', 'products')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('code', 'like', '%' . $this->query . '%')
                            ->orWhere('title', 'like', '%' . $this->query . '%');
                    });
                })
                ->where('business_id', auth()->user()->business_id)
                ->paginate(10)
        ]);
    }
}
