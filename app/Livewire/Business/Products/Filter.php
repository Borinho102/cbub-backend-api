<?php

namespace App\Livewire\Business\Products;

use App\Models\ProductCategory;
use Livewire\Component;

class Filter extends Component
{
    public $category;

    public $categories;

    public function mount()
    {
        $this->categories = ProductCategory::select('id', 'name')
            ->where('is_active', 1)->get();
    }

    public function updatedCategory()
    {
        $this->dispatch('category-updated', $this->category);
    }

    public function render()
    {
        return view('livewire.business.products.filter');
    }
}
