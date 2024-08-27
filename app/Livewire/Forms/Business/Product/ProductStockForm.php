<?php

namespace App\Livewire\Forms\Business\Product;

use App\Enums\StockMovementType;
use App\Models\BusinessUser;
use App\Models\Product;
use App\Models\ProductStock;
use Livewire\Form;

class ProductStockForm extends Form
{
    public $quantity;

    public $comment;

    public $type;

    public $product_id;

    public function store()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'comment' => 'nullable|string',
            'type' => 'required'
        ]);

        if ($this->type == StockMovementType::In) {
            $this->validate([
                'quantity' => 'required|numeric|min:1'
            ]);

            $product = Product::find($this->product_id);

            $productStock = ProductStock::create([
                'old_quantity' => $product->quantity,
                'new_quantity' => $product->quantity + $this->quantity,
                'comment' => $this->comment,
                'product_type' => get_class($product),
                'product_id' => $product->id,
                'type' => StockMovementType::In,
                'author_type' => BusinessUser::class,
                'author_id' => auth('business')->user()->id
            ]);
        } else if ($this->type == StockMovementType::Out)  {
            $product = Product::find($this->product_id);

            $this->validate([
                'quantity' => 'required|numeric|min:1|max:' . $product->quantity,
            ]);

            $productStock = ProductStock::create([
                'old_quantity' => $product->quantity,
                'new_quantity' => $product->quantity - $this->quantity,
                'comment' => $this->comment,
                'product_id' => $product->id,
                'product_type' => get_class($product),
                'type' => StockMovementType::Out,
                'author_type' => BusinessUser::class,
                'author_id' => auth('business')->user()->id
            ]);
        } else {
            abort(404);
        }

        $product->update(['quantity' => $productStock->new_quantity]);

        $this->reset();
    }
}
