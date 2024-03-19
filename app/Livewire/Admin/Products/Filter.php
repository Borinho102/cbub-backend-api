<?php

namespace App\Livewire\Admin\Products;

use App\Models\Business;
use App\Models\ProductCategory;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Filter extends Component
{
    #[Modelable]
    public $form;

    public $categories;

    public $businesses;

    public function mount()
    {
        $this->businesses = Business::select('id', 'name', 'country_id')
            ->with('country')
            ->get();

        $this->categories = ProductCategory::select('id', 'name')
            ->where('is_active', 1)->get();
    }

    public function render()
    {
        return view('livewire.admin.products.filter');
    }
}
