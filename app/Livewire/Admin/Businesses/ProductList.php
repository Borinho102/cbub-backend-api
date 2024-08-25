<?php

namespace App\Livewire\Admin\Businesses;

use App\Models\Business;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class ProductList extends Component
{
    use WithPagination;

    public $query = '';

    private $category;

    private $business;

    public function mount(Business $business)
    {
        $this->business = $business;
    }

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
        return view('livewire.admin.products.index', [
            'business_details' => $this->business,
            'products' => Product::query()
                ->with('business', 'category', 'active_discount')
                ->withAverageRating()
                ->withCount('reviews')
                ->where('business_id', $this->business->id)
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
                ->paginate(10)
        ]);
    }
}
