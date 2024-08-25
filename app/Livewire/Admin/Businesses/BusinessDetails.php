<?php

namespace App\Livewire\Admin\Businesses;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend-app')]
class BusinessDetails extends Component
{
    public function render()
    {
        return view('livewire.admin.businesses.show');
    }
}
