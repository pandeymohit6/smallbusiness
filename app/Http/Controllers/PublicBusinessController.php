<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicBusinessController extends Controller
{
    /**
     * Display a listing of active businesses.
     */
    public function index(Request $request): View
    {
        $query = Business::active();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->byType($request->input('type'));
        }

        if ($request->filled('industry')) {
            $query->byIndustry($request->input('industry'));
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $min = $request->input('min_price', 0);
            $max = $request->input('max_price', 999999999);
            $query->byPriceRange($min, $max);
        }

        $businesses = $query->paginate(12);

        return view('business.index', compact('businesses'));
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business): View
    {
        // Only show active, published businesses to public
        if ($business->status !== 'active' || !$business->published_at || $business->published_at > now()) {
            abort(404);
        }

        return view('business.show', compact('business'));
    }

    /**
     * Store a new inquiry for a business.
     */
    public function storeInquiry(Request $request, Business $business): RedirectResponse
    {
        if ($business->status !== 'active' || !$business->published_at || $business->published_at > now()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        BusinessInquiry::create(array_merge($validated, ['business_id' => $business->id]));

        return redirect()->back()
            ->with('success', __('Your inquiry has been submitted successfully. The business owner will contact you soon.'));
    }
}
