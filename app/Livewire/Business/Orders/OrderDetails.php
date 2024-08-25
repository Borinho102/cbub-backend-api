<?php

namespace App\Livewire\Business\Orders;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend-app')]
class OrderDetails extends Component
{
    public function render()
    {
        return view('livewire.business.orders.details');
    }
}
