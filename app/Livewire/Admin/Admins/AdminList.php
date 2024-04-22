<?php

namespace App\Livewire\Admin\Admins;

use App\Models\Admin;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class AdminList extends Component
{
    use WithPagination;

    public $query = '';

    public $count;

    public function mount()
    {
        $this->count = Admin::count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.admins.index', [
            'admins' => Admin::query()
                ->with('roles', 'country')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%')
                            ->orWhere('email', 'like', '%' . $this->query . '%')
                            ->orWhere('phone', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(20)
        ]);
    }
}
