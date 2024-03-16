<?php

namespace App\Livewire\User\Categories;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class CategoryList extends Component
{
    public function render()
    {
        return view('livewire.user.categories.index');
    }
}
