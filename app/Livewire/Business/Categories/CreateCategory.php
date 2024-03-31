<?php

namespace App\Livewire\Business\Products\Categories;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class CreateCategory extends Component
{
    public function render()
    {
        return view('livewire.business.categories.create');
    }
}
