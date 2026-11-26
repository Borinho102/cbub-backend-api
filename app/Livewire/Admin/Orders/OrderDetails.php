<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend-app')]
class OrderDetails extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order->load([
            'customer',
            'items.product',
            'business',
            'shop',
            'delivery_address',
            'statuses',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.orders.details');
    }
}
