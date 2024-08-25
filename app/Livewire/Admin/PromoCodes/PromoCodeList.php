<?php

namespace App\Livewire\Admin\PromoCodes;

use App\Models\PromoCode;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class PromoCodeList extends Component
{
    use WithPagination;

    public $query = '';

    private $category;

    private $business;

    #[On('business-updated')]
    public function businessUpdated($business)
    {
        $this->business = $business;
    }

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
        return view('livewire.admin.promo_codes.index', [
            'promo_codes' => PromoCode::query()
                ->withCount('users', 'categories', 'products')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('code', 'like', '%' . $this->query . '%')
                            ->orWhere('title', 'like', '%' . $this->query . '%');
                    });
                })
                ->when(! is_null($this->business) && ! empty($this->business), function ($q) {
                    $q->where('business_id', $this->business);
                })
                ->paginate(10)
        ]);
    }
}
