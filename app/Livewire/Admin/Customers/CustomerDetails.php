<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend-app')]
class CustomerDetails extends Component
{
    public Customer $customer;

    public function mount(Customer $customer)
    {
        $this->customer = $customer->load([
            'user',
            'orders' => fn ($q) => $q->latest()->limit(20),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.customers.details');
    }
}
