<?php

namespace App\Livewire\Forms\Admin\Product;

use App\Enums\ProductType;
use App\Enums\StockMovementType;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Shop;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateProductForm extends Form
{
    public ?Product $product;

    public ?Product $parentProduct;

    #[Validate('required|min:5')]
    public $name_en;

    #[Validate('nullable|string|min:5')]
    public $name_fr;

    #[Validate('nullable|unique:products,sku')]
    public $sku;

    #[Validate('required|exists:shops,id', 'Shop')]
    public $shop_id;

    #[Validate('required|exists:product_categories,id', 'Category')]
    public $category_id;

    #[Validate('nullable|exists:products,id,parent_id,NULL', 'Parent Product')]
    public $parent_id;

    #[Validate('required|string|min:5')]
    public $short_description_en;

    #[Validate('nullable|string|min:5')]
    public $short_description_fr;

    #[Validate('nullable|string|min:10')]
    public $description_en;

    #[Validate('nullable|string|min:10')]
    public $description_fr;

    #[Validate('required|numeric')]
    public $price;

    #[Validate('required|image|max:2048')]
    public $thumbnail;

    #[Validate('nullable|file|mimes:pdf|max:5120')]
    public $specifications;

    public $images = [];

    public $tags = [];

    public $quantity;

    public $items_count;

    public $type = ProductType::Physical;

    public function setProduct(Product $product)
    {
        $this->product = $product;

        $this->name_en = $product->getTranslation('name', 'en');

        $this->name_fr = $product->getTranslation('name', 'fr');

        $this->description_en = $product->getTranslation('description', 'en');

        $this->description_fr = $product->getTranslation('description', 'fr');

        $this->short_description_en = $product->getTranslation('short_description', 'en');

        $this->short_description_fr = $product->getTranslation('short_description', 'fr');

        $this->category_id = $product->category_id;

        $this->shop_id = $product->shop_id;

        $this->tags = $product->tags;

        $this->price = $product->price;

        $this->sku = $product->sku;

        $this->type = $product->type;
    }

    public function setParentProduct(Product $product)
    {
        $this->parentProduct = $product;
    }

    public function store(): bool
    {
        $this->normalizeOptionalFields();

        $this->validate(array_merge($this->getRules(), [
            'quantity' => 'required|integer',
            'items_count' => 'nullable|integer',
            'thumbnail' => 'required|image|max:2048',
            'specifications' => 'nullable|file|mimes:pdf|max:5120',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:5120',
        ]));

        try {
            $shop = Shop::findOrFail($this->shop_id);

            $product = Product::create([
                ...$this->only([
                    'price', 'shop_id', 'category_id', 'type',
                    'sku', 'quantity', 'tags',
                ]),
                'business_id' => $shop->business_id,
                'name' => [
                    'en' => $this->name_en,
                    'fr' => $this->name_fr ?: $this->name_en,
                ],
                'slug' => [
                    'en' => generateProductSlugEn($this->name_en),
                    'fr' => generateProductSlugFr(
                        $this->name_fr ?: $this->name_en
                    ),
                ],
                'short_description' => [
                    'en' => $this->short_description_en,
                    'fr' => $this->short_description_fr ?: $this->short_description_en,
                ],
                'description' => [
                    'en' => $this->description_en,
                    'fr' => $this->description_fr,
                ],
            ]);

            $thumbnailPath = $this->thumbnail->getRealPath();
            if (! $thumbnailPath || ! is_file($thumbnailPath)) {
                throw new \RuntimeException('Thumbnail upload is missing or expired. Please re-upload the image.');
            }

            $product
                ->addMedia($thumbnailPath)
                ->usingName($this->thumbnail->getClientOriginalName())
                ->toMediaCollection('thumbnail');

            foreach ($this->images as $image) {
                $imagePath = $image->getRealPath();
                if (! $imagePath || ! is_file($imagePath)) {
                    continue;
                }

                $product
                    ->addMedia($imagePath)
                    ->usingName($image->getClientOriginalName())
                    ->toMediaCollection('images');
            }

            if ($this->specifications) {
                $specPath = $this->specifications->getRealPath();
                if ($specPath && is_file($specPath)) {
                    $product
                        ->addMedia($specPath)
                        ->usingName($this->specifications->getClientOriginalName())
                        ->toMediaCollection('specifications');
                }
            }

            $product->stocks()->create([
                'old_quantity' => 0,
                'new_quantity' => $product->quantity,
                'comment' => 'Initial stock',
                'type' => StockMovementType::In,
                'author_type' => Admin::class,
                'author_id' => auth('admins')->id(),
            ]);
        } catch (\Throwable $e) {
            report($e);
            notify()->error(__('Failed to create product. Please try again.'));

            return false;
        }

        $this->reset();

        notify()->success(__('Product successfully created!'));

        return true;
    }

    public function update()
    {
        $this->normalizeOptionalFields();

        $this->validate(array_merge($this->getRules(), [
            'items_count' => 'nullable|integer',
            'thumbnail' => 'nullable|image|max:2048',
            'specifications' => 'nullable|file|mimes:pdf|max:5120',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:5120',
        ]));

        $shop = Shop::findOrFail($this->shop_id);

        $this->product->update([
            ...$this->only([
                'price', 'shop_id', 'tags', 'type',
                'category_id', 'sku', 'items_count',
            ]),
            'business_id' => $shop->business_id,
            'category_id' => $this->category_id,
            'name' => [
                'en' => $this->name_en,
                'fr' => $this->name_fr ?: $this->name_en,
            ],
            'slug' => [
                'en' => generateProductSlugEn($this->name_en),
                'fr' => generateProductSlugFr(
                    $this->name_fr ?: $this->name_en
                ),
            ],
            'short_description' => [
                'en' => $this->short_description_en,
                'fr' => $this->short_description_fr ?: $this->short_description_en,
            ],
            'description' => [
                'en' => $this->description_en,
                'fr' => $this->description_fr,
            ],
        ]);

        if (! is_null($this->thumbnail)) {
            $this->product
                ->addMedia($this->thumbnail->getRealPath())
                ->usingName($this->thumbnail->getClientOriginalName())
                ->toMediaCollection('thumbnail');
        }

        foreach ($this->images as $image) {
            $this->product
                ->addMedia($image->getRealPath())
                ->usingName($image->getClientOriginalName())
                ->toMediaCollection('images');
        }

        notify()->success(__('Product successfully updated!'));
    }

    protected function normalizeOptionalFields(): void
    {
        foreach ([
            'name_fr',
            'sku',
            'short_description_fr',
            'description_en',
            'description_fr',
            'parent_id',
            'items_count',
        ] as $field) {
            if ($this->{$field} === '' || $this->{$field} === false) {
                $this->{$field} = null;
            }
        }

        if (! is_array($this->tags)) {
            $this->tags = [];
        }

        if (! is_array($this->images)) {
            $this->images = [];
        }
    }
}
