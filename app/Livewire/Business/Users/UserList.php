<?php

namespace App\Livewire\Business\Users;

use App\Models\BusinessUser;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class UserList extends Component
{
    use WithPagination;

    public $query = '';

    public $count;

    public function mount()
    {
        $this->count = BusinessUser::query()
            ->where('business_id', auth()->user()->business_id)
            ->count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.business.users.index', [
            'users' => BusinessUser::query()
                ->with('roles', 'country')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%')
                            ->orWhere('email', 'like', '%' . $this->query . '%')
                            ->orWhere('phone', 'like', '%' . $this->query . '%');
                    });
                })
                ->where('business_id', auth()->user()->business_id)
                ->paginate(20)
        ]);
    }
}
