<?php

namespace App\Livewire\Business\Shops;

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

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.business.shops.index', [
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
                ->where('business_id', auth()->user()->business_id)
                ->paginate(12)
        ]);
    }
}
