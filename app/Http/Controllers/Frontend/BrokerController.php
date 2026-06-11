<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BrokerController extends Controller
{
    /**
     * Show the main advertise page
     */
    public function index(): View
    {
        return view('frontend.brokers.advertise');
    }

    /**
     * Show the advertise page for a specific country
     */
    public function create(string $code): View
    {
        return view('frontend.brokers.advertisecountry');
    }

    /**
     * Show the broker registration login selection page
     */
    public function registrationSelectLogin(string $code): View
    {
        return view('frontend.brokers.registration-select-login-type');
    }

    /**
     * Show the broker registration details page
     */
    public function registrationDetails(): View
    {
        return view('frontend.brokers.registration-details');
    }
}
