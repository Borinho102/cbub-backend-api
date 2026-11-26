<?php

namespace App\Livewire\Admin\Businesses;

use App\Models\Business;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.backend-app')]
class BusinessList extends Component
{
    use WithPagination;

    public $query = '';

    public ?int $businessToDelete = null;

    public string $businessToDeleteName = '';

    public function search()
    {
        $this->resetPage();
    }

    public function confirmDelete(int $businessId): void
    {
        $business = Business::query()->findOrFail($businessId);
        $this->businessToDelete = $business->id;
        $this->businessToDeleteName = $business->name;
        $this->dispatch('open-modal', name: 'delete-business-modal');
    }

    public function deleteBusiness(): void
    {
        if (! $this->businessToDelete) {
            return;
        }

        $business = Business::query()->findOrFail($this->businessToDelete);

        foreach ($business->shops as $shop) {
            $shop->delete();
        }

        $business->delete();

        $this->reset(['businessToDelete', 'businessToDeleteName']);
        $this->dispatch('close-modal', name: 'delete-business-modal');
        notify()->success(__('Business successfully deleted!'));
    }

    public function cancelDelete(): void
    {
        $this->reset(['businessToDelete', 'businessToDeleteName']);
        $this->dispatch('close-modal', name: 'delete-business-modal');
    }

    public function render()
    {
        return view('livewire.admin.businesses.index', [
            'businesses' => Business::with('category', 'country')
                ->withCount('users', 'products', 'shops')
                ->when($this->query, function ($q) {
                    $q->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->query . '%')
                            ->orWhere('slug', 'like', '%' . $this->query . '%')
                            ->orWhere('address', 'like', '%' . $this->query . '%')
                            ->orWhere('phone', 'like', '%' . $this->query . '%')
                            ->orWhere('email', 'like', '%' . $this->query . '%');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }
}
