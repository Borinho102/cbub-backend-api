<?php

namespace App\Livewire\Forms\Business;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\PromoCode;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreatePromoCodeForm extends Form
{
    public ?PromoCode $promoCode;

    public $code;

    #[Validate('required|min:5')]
    public $title;

    #[Validate('required|date|before:end_date')]
    public $start_date;

    #[Validate('required|date|after:start_date')]
    public $end_date;

    #[Validate('nullable|boolean')]
    public $free_delivery;

    #[Validate('nullable|integer', 'Max Usage')]
    public $max_usage;

    #[Validate('nullable|integer', 'Maximum Spend')]
    public $maximum_spend;

    #[Validate('nullable|integer', 'Minimum Spend')]
    public $minimum_spend;

    #[Validate('nullable|integer', 'Max Usage Per User')]
    public $max_usage_per_user;

    #[Validate('nullable|exists:shops,id')]
    public $shop_id;

    #[Validate('nullable|array')]
    public $users = [];

    #[Validate('nullable|array')]
    public $categories = [];

    #[Validate('nullable|array')]
    public $products = [];

    #[Validate('required')]
    // #[Validate('in:' . collect(PromoCode::DISCOUNT_TYPES)->keys()->implode(','))]
    public $discount_type = 'percentage';

    #[Validate('required_if:discount_type,fixed_price')]
    public $discount_price;

    #[Validate('required_if:discount_type,percentage|integer|min:5|max:100')]
    public $discount_percentage;

    #[Validate('nullable|image|max:2048')] // 2MB
    public $banner;

    public function setPromoCode(PromoCode $promoCode)
    {
        $this->promoCode = $promoCode;

        $this->code = $promoCode->code;

        $this->title = $promoCode->title;

        $this->shop_id = $promoCode->shop_id;

        $this->discount_type = $promoCode->discount_type;

        if ($promoCode->discount_type == 'percentage') {
            $this->discount_percentage = $promoCode->discount_value;
        } else {
            $this->discount_price = $promoCode->discount_value;
        }

        $this->users = $promoCode->users->isNotEmpty() ?
            $promoCode->users->pluck('id')->all() : [];

        $this->products = $promoCode->products->isNotEmpty() ?
            $promoCode->products->pluck('id')->all() : [];

        $this->categories = $promoCode->categories->isNotEmpty() ?
            $promoCode->categories->pluck('id')->all() : [];

        $this->free_delivery = $promoCode->free_delivery;

        $this->max_usage = $promoCode->max_usage;

        $this->max_usage_per_user = $promoCode->max_usage_per_user;

        $this->minimum_spend = $promoCode->minimum_spend;

        $this->maximum_spend = $promoCode->maximum_spend;

        $this->start_date = $promoCode->start_date->format('d-m-Y');

        $this->end_date = $promoCode->end_date->format('d-m-Y');
    }

    public function store()
    {
        $this->validate(array_merge($this->getRules(), [
            'code' => 'required|min:4|unique:promo_codes,code'
        ]));

        $promoCode = PromoCode::create([
            ...$this->except('products', 'categories', 'users', 'discount_price', 'discount_percentage', 'banner'),
            'business_id' => auth()->user()->business_id,
            'discount_value' => $this->discount_type === 'percentage' ?
                $this->discount_percentage : $this->discount_price
        ]);

        if ($this->products) {
            foreach ($this->products as $product) {
                Product::find($product)
                    ->promo_codes()
                    ->attach($promoCode);
            }
        }

        if ($this->categories) {
            foreach ($this->categories as $category) {
                ProductCategory::find($category)
                    ->promo_codes()
                    ->attach($promoCode);
            }
        }

        if ($this->users) {
            foreach ($this->users as $user) {
                User::find($user)->promo_codes()
                    ->attach($promoCode);
            }
        }

        $this->reset();

        notify()->success(__('Promo Code successfully created!'));
    }

    public function update()
    {
        $this->validate(array_merge($this->getRules(), [
            'code' => 'required|min:4|unique:promo_codes,code,' . $this->promoCode->id . ',id'
        ]));

        $this->promoCode->update([
            ...$this->except('products', 'categories', 'users', 'discount_price', 'discount_percentage', 'banner'),
            'business_id' => auth()->user()->business_id,
            'discount_value' => $this->discount_type === 'percentage' ?
                $this->discount_percentage : $this->discount_price
        ]);

        if ($this->products) {
            foreach ($this->products as $product) {
                Product::find($product)
                    ->promo_codes()
                    ->sync($this->promoCode);
            }
        }

        if ($this->categories) {
            foreach ($this->categories as $category) {
                ProductCategory::find($category)
                    ->promo_codes()
                    ->sync($this->promoCode);
            }
        }

        if ($this->users) {
            foreach ($this->users as $user) {
                User::find($user)->promo_codes()
                    ->sync($this->promoCode);
            }
        }

        $this->reset();

        notify()->success(__('Promo Code successfully updated!'));
    }
}
