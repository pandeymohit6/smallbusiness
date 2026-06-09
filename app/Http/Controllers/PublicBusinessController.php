<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessInquiry;
use App\Support\CountryUtility;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        if ($request->filled('country')) {
            $countryValue = CountryUtility::normalize($request->input('country'));
            if ($countryValue) {
                $query->where('country_code', $countryValue);
            }
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->input('location')}%");
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

        // Fetch dynamic filter options
        $businessTypes = Business::active()
            ->select('business_type')
            ->distinct()
            ->whereNotNull('business_type')
            ->pluck('business_type')
            ->sort();

        $industries = Business::active()
            ->select('industry')
            ->distinct()
            ->whereNotNull('industry')
            ->pluck('industry')
            ->sort();

        // Get available countries
        $countries = Business::active()
            ->select('country_code')
            ->distinct()
            ->whereNotNull('country_code')
            ->pluck('country_code');

        // Get available locations
        $locations = Business::active()
            ->select('location')
            ->distinct()
            ->whereNotNull('location')
            ->pluck('location')
            ->sort();

        return view('business.index', compact(
            'businesses',
            'businessTypes',
            'industries',
            'countries',
            'locations'
        ));
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

        BusinessInquiry::create(array_merge($validated, [
            'business_id' => $business->id,
            'user_id' => Auth::id(),
        ]));

        return redirect()->back()
            ->with('success', __('Your inquiry has been submitted successfully. The business owner will contact you soon.'));
    }
}
