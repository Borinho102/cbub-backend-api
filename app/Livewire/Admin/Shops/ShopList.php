<?php

namespace App\Livewire\Admin\Shops;

use App\Models\Shop;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class ShopList extends Component
{
    use WithPagination;

    public $query = '';

    public $business;

    #[On('business-updated')]
    public function businessUpdated($business)
    {
        $this->business = $business;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.shops.index', [
            'shops' => Shop::query()
                ->with('business')
                ->withAverageRating()
                ->withOrdersCount()
                ->withCount('reviews', 'products', 'product_sold')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%');
                    });
                })
                ->when(! is_null($this->business) && ! empty($this->business), function ($q) {
                    $q->where('business_id', $this->business);
                })
                ->paginate(12)
        ]);
    }
}
