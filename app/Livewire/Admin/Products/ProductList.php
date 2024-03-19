<?php

namespace App\Livewire\Admin\Products;

use App\Livewire\Forms\Admin\Product\ProductFilterForm;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.backend.app')]
class ProductList extends Component
{
    use WithPagination;

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.products.index', [
            'products' => Product::with('business', 'category')
                ->when($this->form->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name->en', 'like', '%' . $this->form->query . '%')
                            ->orWhere('name->fr', 'like', '%' . $this->form->query . '%')
                            ->orWhere('sku', 'like', '%' . $this->form->query . '%');
                    });
                })
                ->when($this->form->category, function ($q) {
                    $q->where('category_id', $this->form->category);
                })
                ->when($this->form->business, function ($q) {
                    $q->where('business_id', $this->form->business);
                })
                ->paginate(10)
        ]);
    }
}
