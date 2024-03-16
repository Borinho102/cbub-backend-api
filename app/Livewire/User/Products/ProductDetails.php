<?php

namespace App\Livewire\User\Products;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class ProductDetails extends Component
{
    public function render()
    {
        return view('livewire.user.products.show');
    }
}
