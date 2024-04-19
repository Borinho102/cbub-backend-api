<?php

namespace App\Livewire\Forms\Admin\Product;

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\ProductStock;
use Livewire\Form;

class UpdateProductStockForm extends Form
{
    public ?Product $product;

    public $quantity;

    public $comment;

    public $type;

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function setType(StockMovementType $type)
    {
        $this->type = $type;
    }

    public function update()
    {
        if ($this->type == StockMovementType::In) {
            $this->validate([
                'quantity' => 'required|numeric|min:1',
                'comment' => 'nullable|string',
            ]);

            $productStock = ProductStock::create([
                'old_quantity' => $this->product->quantity,
                'new_quantity' => $this->product->quantity + $this->quantity,
                'comment' => $this->comment,
                'product_id' => $this->product->id,
                'type' => StockMovementType::In
            ]);
        } else {
            $this->validate([
                'quantity' => 'required|numeric|min:1|max:' . $this->product->quantity,
                'comment' => 'nullable|string',
            ]);

            $productStock = ProductStock::create([
                'old_quantity' => $this->product->quantity,
                'new_quantity' => $this->product->quantity - $this->quantity,
                'comment' => $this->comment,
                'product_id' => $this->product->id,
                'type' => StockMovementType::Out
            ]);
        }

        $this->product->update(['quantity' => $productStock->new_quantity]);

        $this->reset();

        $this->product = null;
    }
}
