<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.backend-app')]
class Settings extends Component
{
    public string $menu;

    public function mount(string $menu)
    {
        $this->menu = $menu;
    }

    public function render()
    {
        return view('livewire.admin.settings', [
            'menu' => $this->menu
        ]);
    }
}
