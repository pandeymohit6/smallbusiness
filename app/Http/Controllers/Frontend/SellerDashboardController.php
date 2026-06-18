<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the seller dashboard.
     */
    public function dashboard(): View
    {
        $user = auth()->user();

        // Check if user has seller role
        if (!$user->hasRole('Seller')) {
            throw new AuthorizationException('Unauthorized access to seller dashboard.');
        }

        $businesses = Business::where('user_id', $user->id)
            ->latest()
            ->get();

        $activeListings = $businesses->where('status', 'active')->toArray();

        $incompleteListing = $businesses
            ->where('status', 'draft')
            ->first();

        $profileCompletion = 0;

        if ($user->first_name) $profileCompletion += 20;
        if ($user->email) $profileCompletion += 20;
        if ($user->phone) $profileCompletion += 20;
        if ($user->country) $profileCompletion += 20;
        if ($activeListings > 0) $profileCompletion += 20;
        $promotions = [
            [
                'icon' => 'fa-rocket',
                'title' => 'Spotlights',
                'description' => 'Homepage promotion packages.'
            ],
            [
                'icon' => 'fa-envelope-open-text',
                'title' => 'Newsletter',
                'description' => '112k+ subscriber reach.'
            ],
            [
                'icon' => 'fa-paper-plane',
                'title' => 'Solo Emails',
                'description' => 'Targeted buyer campaigns.'
            ],
            [
                'icon' => 'fa-gem',
                'title' => 'Custom Plans',
                'description' => 'Tailored marketing solutions.'
            ]
        ];

        return view('frontend.dashboards.seller.dashboard', [
            'user' => $user,
            'businesses' => $businesses,
            'activeListings' => $activeListings,
            'incompleteListing' => $incompleteListing,
            'profileCompletion' => $profileCompletion,
            'promotions' => $promotions,
        ]);
    }

    /**
     * Show resources page.
     */
    public function resources(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Seller')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.seller.resources', [
            'user' => $user,
        ]);
    }

    /**
     * Show value your business page.
     */
    public function valueBusiness(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Seller')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.seller.value-business', [
            'user' => $user,
        ]);
    }

    /**
     * Show profile settings page.
     */
    public function profile(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Seller')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.seller.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Show account settings page.
     */
    public function settings(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Seller')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.seller.settings', [
            'user' => $user,
        ]);
    }

    public function edit(string $uuid): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Seller')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        $business = Business::where('user_id', $user->id)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('frontend.dashboards.seller.edit-business', [
            'user' => $user,
            'business' => $business,
        ]);
    }

    public function show(Request $request, string $uuid): JsonResponse
    {
        $user = auth()->user();
        if (!$user->hasRole('Seller')) {
            throw new AuthorizationException('Unauthorized access.');
        }
        $country = $request->route('country');
        $business = Business::where('user_id', $user->id)
            ->where('uuid', $uuid)
            ->firstOrFail();
        return response()->json([
            'success' => true,
            'data' => $business
        ], 200);
    }
}
