<?php

namespace App\Livewire\Admin\Businesses;

use App\Models\Business;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class UserList extends Component
{
    use WithPagination;

    public $query = '';

    private $business;

    public function mount(Business $business)
    {
        $this->business = $business;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.users.index', [
            'business_details' => $this->business,
            'users' => User::query()->paginate(10)
        ]);
    }
}
