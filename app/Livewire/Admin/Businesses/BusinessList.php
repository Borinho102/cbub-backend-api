<?php

namespace App\Livewire\Admin\Businesses;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class BusinessList extends Component
{
    public function render()
    {
        return view('livewire.admin.businesses.index');
    }
}
