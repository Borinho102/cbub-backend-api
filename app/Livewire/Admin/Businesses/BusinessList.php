<?php

namespace App\Livewire\Admin\Businesses;

use App\Models\Business;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.backend.app')]
class BusinessList extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.businesses.index', [
            'businesses' => Business::with('category', 'country', 'city')
                ->withCount('users', 'products')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%')
                            ->orWhere('initials', 'like', '%' . $this->query . '%')
                            ->orWhere('slug', 'like', '%' . $this->query . '%')
                            ->orWhere('address', 'like', '%' . $this->query . '%')
                            ->orWhere('phone', 'like', '%' . $this->query . '%')
                            ->orWhere('email', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(10)
        ]);
    }
}
