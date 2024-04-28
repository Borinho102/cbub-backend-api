<?php

namespace App\Livewire\Forms\Admin\Business;

use App\Models\BusinessCategory;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CreateCategoryForm extends Form
{
    use WithFileUploads;

    public ?BusinessCategory $category;

    #[Validate('required|min:4')]
    public $name_en;

    #[Validate('required|min:4')]
    public $name_fr;

    #[Validate('nullable|min:4')]
    public $description_en;

    #[Validate('nullable|min:4')]
    public $description_fr;

    #[Validate('required|min:4|unique:business_categories,code')]
    public $code;

    #[Validate('nullable|image|max:2048')] // 2MB Max
    public $logo;

    public function setCategory(BusinessCategory $category)
    {
        $this->category = $category;

        $this->name_en = $category->getTranslation('name', 'en');

        $this->name_fr = $category->getTranslation('name', 'fr');

        $this->description_en = $category->getTranslation('description', 'en');

        $this->description_fr = $category->getTranslation('description', 'fr');

        $this->code = $category->code;
    }

    public function store()
    {
        $this->validate();

        $category = BusinessCategory::create([
            'code' => $this->code,
            'name' => [
                'en' => $this->name_en,
                'fr' => $this->name_fr
            ],
            'description' => [
                'en' => $this->description_en,
                'fr' => $this->description_fr
            ]
        ]);

        if ($this->logo) {
            $category->addMedia($this->logo);
        }

        $this->reset();

        notify()->success(__('Business category successfully created!'));
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

        if ($this->logo) {
            $this->category->addMedia($this->logo);
        }

        notify()->success(__('Business category successfully updated!'));
    }
}
