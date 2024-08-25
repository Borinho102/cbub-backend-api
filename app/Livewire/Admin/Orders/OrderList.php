<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class OrderList extends Component
{
    use WithPagination;

    public $count;

    public $query = '';

    public function mount()
    {
        $this->count = Order::count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.orders.index', [
            'orders' => Order::query()
                ->with('customer')
                ->withCount('items')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('order_id', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(20)
        ]);
    }
}
