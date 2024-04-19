<?php

namespace App\Livewire\Forms\Admin\Product;

use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductDiscountPrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Form;

class ProductDiscountForm extends Form
{
    public ?Product $product;

    public $price;

    public $start_time;

    public $end_time;

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function store()
    {
        $this->validate([
            'price' => 'required|numeric|max:' . $this->product->price,
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time'
        ]);

        DB::beginTransaction();

        try {
            ProductDiscountPrice::query()
                ->where('product_id', $this->product->id)
                ->update([
                    'is_active' => 0,
                    'end_date' => now()
                ]);

            ProductDiscountPrice::create([
                'product_id' => $this->product->id,
                'old_price' => $this->product->price,
                'new_price' => $this->price,
                'discount_percentage' => round(100 - ($this->price / $this->product->price) * 100, 0),
                'start_date' => $this->start_time,
                'end_date' => $this->end_time,
                'user_type' => Admin::class,
                'user_id' => auth()->user()->id
            ]);

            DB::commit();

            $this->reset();

            $this->product = null;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
