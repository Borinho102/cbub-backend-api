<?php

namespace App\Livewire\Forms\Admin\Product;

use App\Models\Product;
use App\Models\ProductDiscount;
use Illuminate\Support\Facades\DB;
use Livewire\Form;

class ProductDiscountForm extends Form
{
    public ?ProductDiscount $productDiscount;

    public $price;

    public $start_time;

    public $end_time;

    public $is_active;

    public $product_id;

    public function setProductDiscount(ProductDiscount $productDiscount)
    {
        $this->productDiscount = $productDiscount;

        $this->price = $productDiscount->new_price;

        $this->start_time = $productDiscount->start_date;

        $this->end_time = $productDiscount->end_date;

        $this->is_active = $productDiscount->is_active;

        $this->product_id = $productDiscount->product_id;
    }

    public function store()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time'
        ]);

        $product = Product::findOrFail($this->product_id);

        $this->validate([
            'price' => 'required|numeric|max:' . $product->price,
        ]);


        DB::beginTransaction();

        try {
            $user = auth()->user();

            ProductDiscount::query()
                ->where('product_id', $product->id)
                ->update([
                    'is_active' => 0,
                    'end_date' => now()
                ]);

            ProductDiscount::create([
                'product_id' => $product->id,
                'old_price' => $product->price,
                'new_price' => $this->price,
                'discount_percentage' => round(100 - ($this->price / $product->price) * 100, 0),
                'start_date' => $this->start_time,
                'end_date' => $this->end_time,
                'user_type' => get_class($user),
                'user_id' => $user->id
            ]);

            DB::commit();

            $this->reset();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function update()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time',
            'is_active' => 'required|boolean'
        ]);

        $product = Product::findOrFail($this->product_id);

        $this->validate([
            'price' => 'required|numeric|max:' . $product->price,
        ]);

        $user = auth()->user();

        $this->productDiscount->update([
            'new_price' => $this->price,
            'discount_percentage' => round(100 - ($this->price / $product->price) * 100, 0),
            'start_date' => $this->start_time,
            'end_date' => $this->end_time,
            'is_active' => now() > $this->end_time ? false : true,
            'user_type' => get_class($user),
            'user_id' => $user->id
        ]);

        $this->reset();
    }
}
