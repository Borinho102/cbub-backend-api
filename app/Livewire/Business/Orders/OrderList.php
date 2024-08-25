<?php

namespace App\Livewire\Business\Orders;

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
        $this->count = Order::query()
            ->where('business_id', auth()->user()->business_id)
            ->count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.business.orders.index', [
            'orders' => Order::query()
                ->where('business_id', auth()->user()->business_id)
                ->with('customer', 'delivery_address')
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
