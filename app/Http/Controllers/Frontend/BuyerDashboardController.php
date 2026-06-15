<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;

class BuyerDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the buyer dashboard.
     */
    public function dashboard(): View
    {
        $user = auth()->user();

        // Check if user has buyer role
        if (!$user->hasRole('Buyer')) {
            throw new AuthorizationException('Unauthorized access to buyer dashboard.');
        }

        return view('frontend.dashboards.buyer.dashboard', [
            'user' => $user,
        ]);
    }

    /**
     * Show sent inquiries page.
     */
    public function sentInquiries(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Buyer')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.buyer.sent-inquiries', [
            'user' => $user,
        ]);
    }

    /**
     * Show saved searches page.
     */
    public function savedSearches(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Buyer')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.buyer.saved-searches', [
            'user' => $user,
        ]);
    }

    /**
     * Show shortlist page.
     */
    public function shortlist(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Buyer')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.buyer.shortlist', [
            'user' => $user,
        ]);
    }

    /**
     * Show profile settings page.
     */
    public function profile(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Buyer')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.buyer.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Show account settings page.
     */
    public function settings(): View
    {
        $user = auth()->user();

        if (!$user->hasRole('Buyer')) {
            throw new AuthorizationException('Unauthorized access.');
        }

        return view('frontend.dashboards.buyer.settings', [
            'user' => $user,
        ]);
    }
}
