<?php

namespace App\Livewire\Business\Customers;

use App\Models\Customer;
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
        $this->count = Customer::query()
            ->where('business_id', auth()->user()->business_id)
            ->count();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        
        return view('livewire.business.customers.index', [
            'customers' => Customer::query()
                ->with('last_order:id,order_id,amount,customer_id,customer_type,currency')
                ->addSelect(['orders_amount' => function ($q) use ($user) {
                    $q->selectRaw('sum(amount)')
                        ->from('orders')
                        ->where('orders.business_id', $user->business_id)
                        ->whereColumn('customer_id', 'customers.user_id')
                        ->where('customer_type', User::class);
                }])
                ->addSelect(['orders_count' => function ($q) use ($user) {
                    $q->selectRaw('count(id)')
                        ->from('orders')
                        ->where('orders.business_id', $user->business_id)
                        ->whereColumn('customer_id', 'customers.user_id')
                        ->where('customer_type', User::class);
                }])
                ->where('business_id', $user->business_id)
                ->when($this->query, function ($q) {
                    $q->whereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%');
                    });
                })
                ->paginate(20)
        ]);
    }
}
