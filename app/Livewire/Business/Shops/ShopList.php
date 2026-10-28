<?php

namespace App\Livewire\Business\Shops;

use App\Models\Shop;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class ShopList extends Component
{
    use WithPagination;

    public $query = '';

    public ?int $shopToDelete = null;

    public string $shopToDeleteName = '';

    public function search()
    {
        $this->resetPage();
    }

    public function confirmDelete(int $shopId): void
    {
        $shop = Shop::query()
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($shopId);

        $this->shopToDelete = $shop->id;
        $this->shopToDeleteName = $shop->name;
        $this->dispatch('open-modal', name: 'delete-shop-modal');
    }

    public function deleteShop(): void
    {
        if (! $this->shopToDelete) {
            return;
        }

        $shop = Shop::query()
            ->where('business_id', auth()->user()->business_id)
            ->findOrFail($this->shopToDelete);

        $shop->delete();

        $this->reset(['shopToDelete', 'shopToDeleteName']);
        $this->dispatch('close-modal', name: 'delete-shop-modal');
        notify()->success(__('Shop successfully deleted!'));
    }

    public function cancelDelete(): void
    {
        $this->reset(['shopToDelete', 'shopToDeleteName']);
        $this->dispatch('close-modal', name: 'delete-shop-modal');
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
