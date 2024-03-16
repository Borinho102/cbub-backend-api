<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class CategoryList extends Component
{
    public function render()
    {
        return view('livewire.admin.categories.index');
    }
}
