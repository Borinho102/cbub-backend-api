<?php

namespace App\Livewire\Admin;

use App\Models\DataFeed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend.app')]
class Dashboard extends Component
{
    public function render()
    {
        $dataFeed = new DataFeed();

        return view('livewire.admin.dashboard', compact('dataFeed'));
    }
}
