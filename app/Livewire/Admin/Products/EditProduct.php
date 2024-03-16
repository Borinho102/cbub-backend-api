<?php

namespace App\Livewire\Admin\Products;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class EditProduct extends Component
{
    public function render()
    {
        return view('livewire.admin.products.edit');
    }
}
