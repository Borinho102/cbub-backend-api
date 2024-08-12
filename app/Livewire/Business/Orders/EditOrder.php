<?php

namespace App\Livewire\Business\Orders;

use App\Enums\OrderStatus;
use App\Livewire\Forms\Business\UpdateOrderForm;
use App\Models\Order;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.backend.app')]
class EditOrder extends Component
{
    public UpdateOrderForm $form;

    public $statuses;

    public Order $order;

    public function mount($order_id)
    {
        $this->order = Order::with('items.item:id,name,price,quantity')
            ->where('order_id', $order_id)->firstOrFail();

        $this->form->setOrder($this->order);

        $this->statuses = collect(OrderStatus::asSelectArray())
            ->when($this->order->status == OrderStatus::Pending, function (Collection $collection, int $value) {
                return $collection->only([OrderStatus::Pending, OrderStatus::Approved, OrderStatus::Canceled]);
            })
            ->when($this->order->status == OrderStatus::Paid, function (Collection $collection, int $value) {
                return $collection->only([OrderStatus::Paid, OrderStatus::Refunded]);
            })
            ->when($this->order->status == OrderStatus::Approved, function (Collection $collection, int $value) {
                return $collection->only([OrderStatus::Approved, OrderStatus::Paid, OrderStatus::Delivered]);
            })
            ->transform(function ($name, $id) {
                return [
                    'id' => $id,
                    'name' => $name,
                    'disabled' => $id == $this->order->status
                ];
            });
    }

    public function update()
    {
        $updated = $this->form->update();

        if ($updated) {
            notify()->success('Order successfully updated!');

            return $this->redirect(route('business.orders.index'));
        }
    }

    public function render()
    {
        return view('livewire.business.orders.edit');
    }
}
