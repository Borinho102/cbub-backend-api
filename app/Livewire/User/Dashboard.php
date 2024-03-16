<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.backend.app')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.user.dashboard');
    }
}
