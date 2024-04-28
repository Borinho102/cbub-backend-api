<?php

namespace App\Livewire\Admin\Products;

use App\Models\ProductDiscount;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class ProductDiscountList extends Component
{
    use WithPagination;

    public $query = '';

    public $count;

    public function mount()
    {
        $this->count = ProductDiscount::count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.products.discounts.index', [
            'product_discounts' => ProductDiscount::query()
                ->with('product:id,name')
                ->when($this->query, function ($q) {
                    $q->whereHas('product', function ($q) {
                        $q->where('name->en', 'like', '%' . $this->query . '%')
                            ->orWhere('name->fr', 'like', '%' . $this->query . '%')
                            ->orWhere('sku', 'like', '%' . $this->query . '%');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20)
        ]);
    }
}
