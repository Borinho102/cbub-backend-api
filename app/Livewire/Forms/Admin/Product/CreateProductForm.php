<?php

namespace App\Livewire\Forms\Admin\Product;

use App\Models\Product;
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

    #[Validate('required|number')]
    public $price;

    #[Validate('required|integer')]
    public $quantity;

    #[Validate('required|image|max:5120')] // 5MB Max
    public $images = [];

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
    }

    public function store()
    {
        $this->validate();

        $product = Product::create([
            ...$this->only([
                'price', 'business_id', 'category_id',
                'sku', 'quantity'
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
            ],
        ]);

        $this->reset();
    }

    public function update()
    {
        $this->product->update([
            ...$this->only([
                'price', 'business_id',
                'category_id', 'sku', 'quantity'
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
    }
}
