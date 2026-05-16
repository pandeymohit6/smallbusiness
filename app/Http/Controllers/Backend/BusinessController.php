<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Models\Business;
use App\Models\BusinessInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of businesses.
     */
    public function index(): View
    {
        return view('backend.business.index');
    }

    /**
     * Show the form for creating a new business.
     */
    public function create(): View
    {
        return view('backend.business.create');
    }

    /**
     * Store a newly created business in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'overview' => ['nullable', 'string'],
            'business_type' => ['required', 'string'],
            'industry' => ['required', 'string'],
            'location' => ['required', 'string'],
            'asking_price' => ['required', 'numeric', 'min:0'],
            'annual_revenue' => ['nullable', 'numeric', 'min:0'],
            'annual_profit' => ['nullable', 'numeric', 'min:0'],
            'years_in_operation' => ['nullable', 'integer', 'min:0'],
            'employees' => ['nullable', 'integer', 'min:0'],
            'features' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
        ]);

        Business::create($validated);

        return redirect()->route('admin.business.index')
            ->with('success', __('Business created successfully.'));
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business): View
    {
        return view('backend.business.show', compact('business'));
    }

    /**
     * Show the form for editing the specified business.
     */
    public function edit(Business $business): View
    {
        return view('backend.business.edit', compact('business'));
    }

    /**
     * Update the specified business in storage.
     */
    public function update(Request $request, Business $business): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'overview' => ['nullable', 'string'],
            'business_type' => ['required', 'string'],
            'industry' => ['required', 'string'],
            'location' => ['required', 'string'],
            'asking_price' => ['required', 'numeric', 'min:0'],
            'annual_revenue' => ['nullable', 'numeric', 'min:0'],
            'annual_profit' => ['nullable', 'numeric', 'min:0'],
            'years_in_operation' => ['nullable', 'integer', 'min:0'],
            'employees' => ['nullable', 'integer', 'min:0'],
            'features' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,active,sold,delisted'],
        ]);

        $business->update($validated);

        return redirect()->route('admin.business.show', $business)
            ->with('success', __('Business updated successfully.'));
    }

    /**
     * Delete the specified business.
     */
    public function destroy(Business $business): RedirectResponse
    {
        $business->delete();

        return redirect()->route('admin.business.index')
            ->with('success', __('Business deleted successfully.'));
    }

    /**
     * Display inquiries for a business.
     */
    public function inquiries(Business $business): View
    {
        return view('backend.business.inquiries', compact('business'));
    }

    /**
     * Reply to an inquiry.
     */
    public function replyInquiry(BusinessInquiry $inquiry): RedirectResponse
    {
        $validated = request()->validate([
            'reply_message' => ['required', 'string'],
        ]);

        $inquiry->markAsReplied($validated['reply_message']);

        return redirect()->back()
            ->with('success', __('Reply sent successfully.'));
    }
}
