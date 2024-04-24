<?php

namespace App\Livewire\Forms\Admin\Product;

use App\Models\ProductCategory;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateProductCategoryForm extends Form
{
    use WithFileUploads;

    public ?ProductCategory $category;

    #[Validate('required|min:4')]
    public $name_en;

    #[Validate('required|min:4')]
    public $name_fr;

    #[Validate('nullable|min:4')]
    public $description_en;

    #[Validate('nullable|min:4')]
    public $description_fr;

    #[Validate('required|min:4|unique:product_categories,code')]
    public $code;

    #[Validate('nullable|exists:product_categories,id')]
    public $parent_id;

    #[Validate('nullable|image|max:2048')] // 2MB Max
    public $icon;

    #[Validate('nullable|image|max:2048')] // 2MB Max
    public $banner_image;

    #[Validate('nullable|image|max:2048')] // 2MB Max
    public $cover_image;

    #[Validate('nullable')]
    public $tags;

    public function setCategory(ProductCategory $category)
    {
        $this->category = $category;

        $this->name_en = $category->getTranslation('name', 'en');

        $this->name_fr = $category->getTranslation('name', 'fr');

        $this->description_en = $category->getTranslation('description', 'en');

        $this->description_fr = $category->getTranslation('description', 'fr');

        $this->parent_id = $category->parent_id;

        $this->tags = $category->tags;

        $this->code = $category->code;
    }

    public function store()
    {
        $this->validate();

        $category = ProductCategory::create([
            ...$this->only('code', 'parent_id', 'tags'),
            'name' => [
                'en' => $this->name_en,
                'fr' => $this->name_fr
            ],
            'description' => [
                'en' => $this->description_en,
                'fr' => $this->description_fr
            ]
        ]);

        if ($this->icon) {
            $category
                ->addMedia($this->icon->getRealPath())
                ->usingName($this->icon->getClientOriginalName())
                ->toMediaCollection('icon_image');
        }

        if ($this->cover_image) {
            $category
                ->addMedia($this->cover_image->getRealPath())
                ->usingName($this->cover_image->getClientOriginalName())
                ->toMediaCollection('cover_image');
        }

        if ($this->banner_image) {
            $category
                ->addMedia($this->banner_image->getRealPath())
                ->usingName($this->banner_image->getClientOriginalName())
                ->toMediaCollection('banner_image');
        }

        $this->reset();

        notify()->success(__('Product category successfully created!'));
    }

    public function update()
    {
        $this->category->update([
            ...$this->except('name_en', 'name_fr', 'description_fr', 'description_en'),
            'name' => [
                'en' => $this->name_en,
                'fr' => $this->name_fr
            ],
            'description' => [
                'en' => $this->description_en,
                'fr' => $this->description_fr
            ]
        ]);

        if ($this->icon) {
            $this->category
                ->addMedia($this->icon->getRealPath())
                ->usingName($this->icon->getClientOriginalName())
                ->toMediaCollection('icon_image');
        }

        if ($this->cover_image) {
            $this->category
                ->addMedia($this->cover_image->getRealPath())
                ->usingName($this->cover_image->getClientOriginalName())
                ->toMediaCollection('cover_image');
        }

        if ($this->banner_image) {
            $this->category
                ->addMedia($this->banner_image->getRealPath())
                ->usingName($this->banner_image->getClientOriginalName())
                ->toMediaCollection('banner_image');
        }

        notify()->success(__('Product category successfully updated!'));
    }
}
