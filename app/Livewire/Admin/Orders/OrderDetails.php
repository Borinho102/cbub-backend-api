<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class OrderDetails extends Component
{
    public function render()
    {
        return view('livewire.amin.orders.details');
    }
}
