<?php

declare(strict_types=1);

namespace App\Livewire\Backend;

use App\Models\Business;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class BusinessManagement extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public ?Business $selectedBusiness = null;

    protected $queryString = ['search', 'status'];

    public function render()
    {
        $businesses = Business::query()
            ->when($this->search, fn ($query) => $query->where('title', 'like', "%{$this->search}%")
                ->orWhere('location', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.backend.business-management', [
            'businesses' => $businesses,
            'statuses' => Business::getStatuses(),
            'businessTypes' => Business::getBusinessTypes(),
            'industries' => Business::getIndustries(),
        ]);
    }

    public function openCreateModal(): void
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal(): void
    {
        $this->showCreateModal = false;
        $this->reset(['selectedBusiness']);
    }

    public function openEditModal(Business $business): void
    {
        $this->selectedBusiness = $business->load('galleries');
        $this->showEditModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->reset(['selectedBusiness']);
    }

    public function deleteBusiness(Business $business): void
    {
        $business->delete();
        $this->dispatch('success', message: __('Business deleted successfully.'));
        $this->resetPage();
    }

    public function toggleFeatured(Business $business): void
    {
        $business->update(['is_featured' => !$business->is_featured]);
        $this->dispatch('success', message: __('Business updated successfully.'));
    }

    public function publishBusiness(Business $business): void
    {
        $business->update([
            'status' => 'active',
            'published_at' => now(),
        ]);
        $this->dispatch('success', message: __('Business published successfully.'));
    }

    public function unpublishBusiness(Business $business): void
    {
        $business->update([
            'status' => 'draft',
            'published_at' => null,
        ]);
        $this->dispatch('success', message: __('Business unpublished successfully.'));
    }
}
