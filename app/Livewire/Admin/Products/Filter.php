<?php

namespace App\Livewire\Admin\Products;

use App\Models\Business;
use App\Models\ProductCategory;
use Livewire\Component;

class Filter extends Component
{
    public $business;

    public $category;

    public $categories;

    public $businesses;

    public function mount()
    {
        $this->businesses = Business::select('id', 'name', 'country_id')
            ->with('country')
            ->get();

        $this->categories = ProductCategory::select('id', 'name')
            ->where('is_active', 1)->get();
    }

    public function updatedBusiness()
    {
        $this->dispatch('business-updated', $this->business);
    }

    public function updatedCategory()
    {
        $this->dispatch('category-updated', $this->category);
    }

    public function render()
    {
        return view('livewire.admin.products.filter');
    }
}
