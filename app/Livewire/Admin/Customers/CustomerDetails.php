<?php

namespace App\Livewire\Admin\Customers;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend-app')]
class CustomerDetails extends Component
{
    public function render()
    {
        return view('livewire.amin.customers.details');
    }
}
