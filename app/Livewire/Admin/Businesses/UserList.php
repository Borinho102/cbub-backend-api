<?php

namespace App\Livewire\Admin\Businesses;

use App\Models\Business;
use App\Models\BusinessUser;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class UserList extends Component
{
    use WithPagination;

    public Business $business;

    public $query = '';

    public $count = 0;

    public function mount(Business $business)
    {
        $this->business = $business;
        $this->count = BusinessUser::query()
            ->where('business_id', $business->id)
            ->count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.businesses.users.index', [
            'users' => BusinessUser::query()
                ->with('roles')
                ->where('business_id', $this->business->id)
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%')
                            ->orWhere('email', 'like', '%' . $this->query . '%')
                            ->orWhere('phone', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(10),
        ]);
    }
}
