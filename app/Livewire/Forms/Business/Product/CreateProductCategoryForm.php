<?php

namespace App\Livewire\Forms\Business\Product;

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
    public $image;

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

        if ($this->image) {
            $category
                ->addMedia($this->image->getRealPath())
                ->usingName($this->image->getClientOriginalName())
                ->toMediaCollection('image');
        }

        $this->reset();

        notify()->success(__('Category successfully created!'));
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

        if ($this->image) {
            $this->category
                ->addMedia($this->image->getRealPath())
                ->usingName($this->image->getClientOriginalName())
                ->toMediaCollection('image');
        }

        notify()->success(__('Category successfully updated!'));
    }
}
