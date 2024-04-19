<?php

namespace App\Livewire\Admin\Products;

use App\Enums\StockMovementType;
use App\Livewire\Forms\Admin\Product\UpdateProductStockForm;
use App\Models\ProductStock;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class ProductStockList extends Component
{
    use WithPagination;

    public UpdateProductStockForm $updateStockForm;

    public $query = '';

    public $count;

    public $selectedItems = [];

    public $selectedProduct;

    public $stockMovementType;

    public function mount()
    {
        $this->count = ProductStock::count();
    }

    public function updatedSelectedItems($value)
    {
        if (count($this->selectedItems) == 1) {
            $this->selectedProduct = ProductStock::with('product:id,name,quantity')
                ->where('id', $this->selectedItems[0])->firstOrFail();
            $this->updateStockForm->setProduct($this->selectedProduct->product);
        }
    }

    #[On('show-add-stock-modal')]
    public function showAddStockModal()
    {
        $this->stockMovementType = StockMovementType::In;
        $this->dispatch('open-modal', 'update-stock-modal');
    }

    #[On('show-remove-stock-modal')]
    public function showRemoveStockModal()
    {
        $this->stockMovementType = StockMovementType::Out;
        $this->dispatch('open-modal', 'update-stock-modal');
    }

    public function updateStock()
    {
        $this->updateStockForm->setType($this->stockMovementType);

        $this->updateStockForm->update();

        $this->dispatch('close-modal', 'update-stock-modal');

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
