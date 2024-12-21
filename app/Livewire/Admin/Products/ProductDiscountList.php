<?php

namespace App\Livewire\Admin\Products;

use App\Livewire\Forms\Admin\Product\ProductDiscountForm;
use App\Models\ProductDiscount;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class ProductDiscountList extends Component
{
    use WithPagination;

    public ProductDiscountForm $discountForm;

    public $query = '';

    public $count;

    public $mode;

    public function mount()
    {
        $this->count = ProductDiscount::count();

        $this->mode = 'create';
    }

    #[On('show-discount-modal')]
    public function showDiscountModal(?int $discount_id = null)
    {
        $this->dispatch('log', sprintf('SHOW DISCOUNT MODAL => %s', $discount_id));
        if ($discount_id) {
            $this->mode = 'update';
            $this->discountForm->setProductDiscount(
                ProductDiscount::with('product')->findOrFail($discount_id)
            );

            $this->dispatch('open-modal', name: 'product-discount-modal', mode: 'update');
        } else {
            $this->dispatch('open-modal', name: 'product-discount-modal', mode: 'create');
        }
    }

    public function saveDiscount()
    {
        $this->discountForm->store();

        $this->dispatch('close-modal', name: 'product-discount-modal');

        notify()->success(__('Product discount successfully updated!'));
    }

    public function toggleStatus(ProductDiscount $discount)
    {
        $discount->update(['is_active' => !$discount->is_active]);

        notify()->success(__('Product discount successfully toggled!'));
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
