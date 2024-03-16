<?php

namespace App\Livewire\User\Products;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class ProductList extends Component
{
    public function render()
    {
        return view('livewire.user.products.index');
    }
}
