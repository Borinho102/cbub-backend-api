<?php

namespace App\Livewire\Admin\Products;

use App\Livewire\Forms\Admin\Product\ProductDiscountForm;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class ProductList extends Component
{
    use WithPagination;

    public ProductDiscountForm $discountForm;

    public $query = '';

    private $category;

    private $business;

    #[On('business-updated')]
    public function businessUpdated($business)
    {
        $this->business = $business;
    }

    #[On('category-updated')]
    public function categoryUpdated($category)
    {
        $this->category = $category;
    }

    #[On('show-discount-modal')]
    public function showDiscountModal(Product $product) {
        $this->discountForm->setProduct($product);

        $this->dispatch('open-modal', 'product-discount-modal');
    }

    public function saveDiscount() {
        $this->discountForm->store();

        $this->dispatch('close-modal', 'product-discount-modal');

        notify()->success(__('Product discount successfully created!'));
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.products.index', [
            'products' => Product::query()
                ->with('business', 'category', 'active_discount_price')
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
                ->when(! is_null($this->business) && ! empty($this->business), function ($q) {
                    $q->where('business_id', $this->business);
                })
                ->paginate(10)
        ]);
    }
}
