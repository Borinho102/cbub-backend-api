<?php

namespace App\Livewire\Forms\Admin\Product;

use App\Enums\StockMovementType;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductStock;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateProductForm extends Form
{
    public ?Product $product;

    #[Validate('required|min:5')]
    public $name_en;

    #[Validate('required|min:5')]
    public $name_fr;

    #[Validate('nullable|unique:products,sku')]
    public $sku;

    #[Validate('required|exists:businesses,id', 'Business')]
    public $business_id;

    #[Validate('required|exists:product_categories,id', 'Category')]
    public $category_id;

    #[Validate('required')]
    public $short_description_en;

    #[Validate('required')]
    public $short_description_fr;

    #[Validate('nullable|string')]
    public $description_en;

    #[Validate('nullable|string')]
    public $description_fr;

    #[Validate('required|numeric')]
    public $price;

    #[Validate('required|image|max:2048')]
    public $thumbnail;

    #[Validate(['images.*' => 'image|max:5120'])] // 5MB Max
    public $images = [];

    #[Validate(['nullable'])]
    public $tags = [];

    public $quantity;

    public function setProduct(Product $product)
    {
        $this->product = $product;

        $this->name_en = $product->getTranslation('name', 'en');

        $this->name_fr = $product->getTranslation('name', 'fr');

        $this->description_en = $product->getTranslation('description', 'en');

        $this->description_fr = $product->getTranslation('description', 'fr');

        $this->short_description_en = $product->getTranslation('short_description_en', 'en');

        $this->short_description_fr = $product->getTranslation('short_description_fr', 'fr');

        $this->category_id = $product->category_id;

        $this->business_id = $product->business_id;

        $this->tags = $product->tags;
    }

    public function store()
    {
        $this->validate(array_merge($this->getRules(), [
            'quantity' => 'required|integer'
        ]));

        $product = Product::create([
            ...$this->only([
                'price', 'business_id', 'category_id',
                'sku', 'quantity', 'tags'
            ]),
            'name' => [
                'en' => $this->name_en,
                'fr' => $this->name_fr,
            ],
            'slug' => [
                'en' => generateProductSlugEn($this->name_en),
                'fr' => generateProductSlugFr($this->name_fr),
            ],
            'short_description' => [
                'en' => $this->short_description_en,
                'fr' => $this->short_description_fr,
            ],
            'description' => [
                'en' => $this->description_en,
                'fr' => $this->description_fr
            ],
        ]);

        $product
            ->addMedia($this->thumbnail->getRealPath())
            ->usingName($this->thumbnail->getClientOriginalName())
            ->toMediaCollection('thumbnail');

        foreach ($this->images as $image) {
            $product
                ->addMedia($image->getRealPath())
                ->usingName($image->getClientOriginalName())
                ->toMediaCollection('images');
        }

        ProductStock::create([
            'old_quantity' => 0,
            'new_quantity' => $product->quantity,
            'comment' => 'Initial stock',
            'product_id' => $product->id,
            'type' => StockMovementType::In,
            'author_type' => Admin::class,
            'author_id' => auth('admins')->user()->id
        ]);

        $this->reset();

        notify()->success(__('Product successfully created!'));
    }

    public function update()
    {
        $this->product->update([
            ...$this->only([
                'price', 'business_id', 'tags',
                'category_id', 'sku'
            ]),
            'slug' => [
                'en' => generateProductSlugEn($this->name_en),
                'fr' => generateProductSlugFr($this->name_fr),
            ],
            'short_description' => [
                'en' => $this->short_description_en,
                'fr' => $this->short_description_fr,
            ],
            'description' => [
                'en' => $this->description_en,
                'fr' => $this->description_fr
            ]
        ]);

        if (! is_null($this->thumbnail)) {
            $this->product
                ->addMedia($this->thumbnail->getRealPath())
                ->usingName($this->thumbnail->getClientOriginalName())
                ->toMediaCollection('thumbnail');
        }

        notify()->success(__('Product successfully updated!'));
    }
}
