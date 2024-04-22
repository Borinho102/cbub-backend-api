<?php

namespace App\Livewire\Business\Products;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class EditProduct extends Component
{
    public function render()
    {
        return view('livewire.business.products.edit');
    }
}
