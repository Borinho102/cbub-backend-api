<?php

namespace App\Livewire\Admin\Customers;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend.app')]
class CustomerList extends Component
{
    use WithPagination;

    public $count;

    public $query = '';

    public function mount()
    {
        $this->count = User::whereHas('orders')->count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.customers.index', [
            'customers' => User::query()
                ->addSelect(['orders_amount' => function ($q) {
                    $q->selectRaw('sum(amount)')
                        ->from('orders')
                        ->whereColumn('customer_id', 'users.id')
                        ->where('customer_type', User::class);
                }])
                ->whereHas('orders')
                ->withCount('orders')
                ->with(['orders', 'current_location:id,name,user_id', 'last_order:id,order_id,amount,customer_id,customer_type,currency'])
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(20)
        ]);
    }
}
