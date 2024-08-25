<?php

namespace App\Livewire\Admin\Products;

use App\Livewire\Forms\Admin\Product\ProductStockForm;
use App\Models\ProductStock;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class ProductStockList extends Component
{
    use WithPagination;

    public ProductStockForm $productStockForm;

    public $query = '';

    public $count;

    public function mount()
    {
        $this->count = ProductStock::count();
    }


    #[On('show-stock-modal')]
    public function showStockModal()
    {
        $this->dispatch('open-modal', name: 'create-stock-modal');
    }

    public function saveStock()
    {
        $this->productStockForm->store();

        $this->dispatch('close-modal', name: 'create-stock-modal');

        notify()->success(__('Product stock successfully updated!'));
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.products.stocks.index', [
            'product_stocks' => ProductStock::query()
                ->with('product', 'author')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->whereHas('product', function ($q) {
                            $q->where('name->en', 'like', '%' . $this->query . '%')
                                ->orWhere('name->fr', 'like', '%' . $this->query . '%')
                                ->orWhere('sku', 'like', '%' . $this->query . '%');
                        });
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20)
        ]);
    }
}
