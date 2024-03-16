<?php

namespace App\Livewire\User\Products\Categories;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class CreateCategory extends Component
{
    public function render()
    {
        return view('livewire.user.categories.create');
    }
}
