<?php

namespace App\Livewire\Business\Categories;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class CategoryList extends Component
{
    public function render()
    {
        return view('livewire.business.categories.index');
    }
}
