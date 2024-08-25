<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class ProductReviewList extends Component
{
    use WithPagination;

    public $query = '';

    public $count;

    public function mount()
    {
        $this->count = Review::where('reviewable_type', Product::class)->count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function toggleStatus(Review $review)
    {
        $review->update(['published' => !$review->published]);

        notify()->success(__('Product review successfully toggled!'));
    }

    public function render()
    {
        return view('livewire.admin.products.reviews.index', [
            'product_reviews' => Review::query()
                ->with('reviewable:id,name', 'user:id,last_name,first_name,email')
                ->whereHasMorph('reviewable', [Product::class], function ($q) {
                    $q->when($this->query, function ($q) {
                        $q->where(function ($q) {
                            $q->where('name->en', 'like', '%' . $this->query . '%')
                                ->orWhere('name->fr', 'like', '%' . $this->query . '%')
                                ->orWhere('sku', 'like', '%' . $this->query . '%');
                        });
                    });
                })
                ->paginate(20)
        ]);
    }
}
