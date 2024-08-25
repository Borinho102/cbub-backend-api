<?php

namespace App\Livewire\Business;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend-app')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.business.dashboard');
    }
}
