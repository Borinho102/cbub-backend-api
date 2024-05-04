<?php

namespace App\Livewire\Business\Products\Categories;

use App\Models\ProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class CategoryList extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.business.products.categories.index', [
            'categories' => ProductCategory::withCount('products')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name->en', 'like', '%' . $this->query . '%')
                            ->orWhere('name->fr', 'like', '%' . $this->query . '%')
                            ->orWhere('code', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(10)
        ]);
    }
}
