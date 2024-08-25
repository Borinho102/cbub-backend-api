<?php

namespace App\Livewire\Admin\Businesses\Categories;

use App\Models\BusinessCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
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
        return view('livewire.admin.businesses.categories.index', [
            'categories' => BusinessCategory::withCount('businesses')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name->en', 'like', '%' . $this->query . '%')
                            ->orWhere('name->fr', 'like', '%' . $this->query . '%')
                            ->orWhere('code', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(10),
        ]);
    }
}
