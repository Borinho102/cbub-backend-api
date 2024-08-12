<?php

namespace App\Livewire\Business\Products;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class ProductList extends Component
{
    use WithPagination;

    public $query = '';

    private $category;

    #[On('category-updated')]
    public function categoryUpdated($category)
    {
        $this->category = $category;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.business.products.index', [
            'products' => Product::query()
                ->with('business', 'category', 'active_discount')
                ->withAverageRating()
                ->withCount('reviews')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name->en', 'like', '%' . $this->query . '%')
                            ->orWhere('name->fr', 'like', '%' . $this->query . '%')
                            ->orWhere('sku', 'like', '%' . $this->query . '%');
                    });
                })
                ->when(! is_null($this->category) && ! empty($this->category), function ($q) {
                    $q->where('category_id', $this->category);
                })
                ->where('business_id', auth()->user()->business_id)
                ->paginate(12)
        ]);
    }
}
