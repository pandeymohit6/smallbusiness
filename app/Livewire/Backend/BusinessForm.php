<?php

declare(strict_types=1);

namespace App\Livewire\Backend;

use App\Models\Business;
use App\Models\BusinessGallery;
use Livewire\Component;
use Livewire\WithFileUploads;

class BusinessForm extends Component
{
    use WithFileUploads;

    public ?Business $business = null;

    public string $title = '';
    public string $description = '';
    public string $overview = '';
    public string $businessType = '';
    public string $industry = '';
    public string $location = '';
    public string $askingPrice = '';
    public string $annualRevenue = '';
    public string $annualProfit = '';
    public string $yearsInOperation = '';
    public string $employees = '';
    public string $features = '';
    public string $highlights = '';
    public bool $isFeatured = false;

    public function mount(Business $business = null): void
    {
        if ($business) {
            $this->business = $business;
            $this->title = $business->title;
            $this->description = $business->description;
            $this->overview = $business->overview ?? '';
            $this->businessType = $business->business_type;
            $this->industry = $business->industry;
            $this->location = $business->location;
            $this->askingPrice = (string)$business->asking_price;
            $this->annualRevenue = (string)($business->annual_revenue ?? '');
            $this->annualProfit = (string)($business->annual_profit ?? '');
            $this->yearsInOperation = (string)($business->years_in_operation ?? '');
            $this->employees = (string)($business->employees ?? '');
            $this->features = $business->features ?? '';
            $this->highlights = $business->highlights ?? '';
            $this->isFeatured = $business->is_featured;
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'overview' => ['nullable', 'string'],
            'businessType' => ['required', 'string'],
            'industry' => ['required', 'string'],
            'location' => ['required', 'string'],
            'askingPrice' => ['required', 'numeric', 'min:0'],
            'annualRevenue' => ['nullable', 'numeric', 'min:0'],
            'annualProfit' => ['nullable', 'numeric', 'min:0'],
            'yearsInOperation' => ['nullable', 'integer', 'min:0'],
            'employees' => ['nullable', 'integer', 'min:0'],
            'features' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'isFeatured' => ['boolean'],
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'overview' => $validated['overview'],
            'business_type' => $validated['businessType'],
            'industry' => $validated['industry'],
            'location' => $validated['location'],
            'asking_price' => $validated['askingPrice'],
            'annual_revenue' => $validated['annualRevenue'],
            'annual_profit' => $validated['annualProfit'],
            'years_in_operation' => $validated['yearsInOperation'],
            'employees' => $validated['employees'],
            'features' => $validated['features'],
            'highlights' => $validated['highlights'],
            'is_featured' => $validated['isFeatured'],
        ];

        if ($this->business) {
            $this->business->update($data);
            $this->dispatch('success', message: __('Business updated successfully.'));
        } else {
            Business::create($data);
            $this->dispatch('success', message: __('Business created successfully.'));
            $this->resetForm();
        }
    }

    public function resetForm(): void
    {
        $this->reset([
            'title', 'description', 'overview', 'businessType', 'industry',
            'location', 'askingPrice', 'annualRevenue', 'annualProfit',
            'yearsInOperation', 'employees', 'features', 'highlights', 'isFeatured'
        ]);
    }

    public function render()
    {
        return view('livewire.backend.business-form', [
            'businessTypes' => Business::getBusinessTypes(),
            'industries' => Business::getIndustries(),
        ]);
    }
}
