<?php

namespace App\Livewire\Admin\Products;

use App\Models\ProductReview;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class ProductReviewList extends Component
{
    use WithPagination;

    public $query = '';

    public $count;

    public function mount()
    {
        $this->count = ProductReview::count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.products.reviews.index', [
            'product_reviews' => ProductReview::query()
                ->with('product:id,name', 'user:id,name,email')
                ->when($this->query, function ($q) {
                    $q->whereHas('product', function ($q) {
                        $q->where('name->en', 'like', '%' . $this->query . '%')
                            ->orWhere('name->fr', 'like', '%' . $this->query . '%')
                            ->orWhere('sku', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(20)
        ]);
    }
}
