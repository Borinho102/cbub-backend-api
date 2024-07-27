<?php

namespace App\Livewire\Forms\Business;

use App\Enums\OrderStatus as EnumsOrderStatus;
use App\Enums\StockMovementType;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductStock;
use App\Notifications\OrderUpdated;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateOrderForm extends Form
{
    public ?Order $order = null;

    public $products = [];

    public $orderItems = [];

    #[Validate('required|' . new EnumValue(EnumsOrderStatus::class))]
    public $status;

    public $note;

    public function setOrder(Order $order)
    {
        $this->order = $order;

        $this->products = $order->items->pluck('item');

        $this->orderItems = $order->items->toArray();

        $this->status = $this->order->status;
    }

    public function update()
    {
        $this->validate();

        $user = auth()->user();

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            if ($this->status == EnumsOrderStatus::Approved) {
                if (collect($this->orderItems)->where('status', EnumsOrderStatus::Approved)->count() === 0) {
                    throw new \Exception('At leat one order item should have the status approved!');
                }

                foreach ($this->orderItems as $item) {
                    if ($item['status'] == EnumsOrderStatus::Approved) {
                        if ($item['quantity'] > $item['item']['quantity']) {
                            throw new \Exception('Invalid product quantity!');
                        }

                        $totalAmount += $item['quantity'] * $item['unit_amount'];
                        Product::where('id', $item['item_id'])->update([
                            'quantity' => $item['item']['quantity'] - $item['quantity']
                        ]);

                        ProductStock::create([
                            'product_id' => $item['item']['id'],
                            'product_type' => Product::class,
                            'type' => StockMovementType::Out,
                            'old_quantity' => $item['item']['quantity'],
                            'new_quantity' => $item['item']['quantity'] - $item['quantity'],
                            'author_id' => $user->id,
                            'author_type' => get_class($user),
                        ]);
                    }

                    OrderItem::where('id', $item['id'])
                        ->update([
                            'quantity' => $item['quantity'],
                            'total_amount' => $item['quantity'] * $item['unit_amount'],
                            'status' => $item['status']
                        ]);
                }
            } else if ($this->status == EnumsOrderStatus::Canceled) {
                OrderItem::whereIn('id', array_column( $this->orderItems, 'id'))->update([
                    'status' => $this->status
                ]);
            }


            $orderStatus = OrderStatus::create([
                'order_id' => $this->order->id,
                'from_status' => $this->order->status,
                'to_status' => $this->status,
                'user_id' => $user->id,
                'user_type' => get_class($user)
            ]);

            $this->order->update([
                'status' => $this->status,
                'amount' => $totalAmount > 0 ? $totalAmount : $this->order->amount
            ]);

            DB::commit();

            $this->order->customer->notify(new OrderUpdated($orderStatus));

            $this->reset();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
