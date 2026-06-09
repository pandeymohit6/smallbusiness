<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Enums\Country;
use App\Http\Controllers\Controller;
use App\Support\CountryUtility;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('frontend.home');
    }

    public function loginPage(): View
    {
        return view('frontend.login');
    }

    public function registerPage(): View
    {
        return view('frontend.register');
    }

    public function getPages(string $slug): View
    {
        $pages = Post::where('slug', $slug)->firstOrFail();
        return view('frontend.pages', compact('pages'));
    }
    public function sellYourBusiness(): View
    {
        return view('frontend.sellers.sell-your-business');
    }

    public function sellYourBusinessForm(): View
    {
        return view('frontend.sellers.sell-your-business-login');
    }

    public function sellerRegistrationSelectLogin(): View
    {
        return view('frontend.sellers.registration-select-login');
    }

    public function advertise(): View
    {
        return view('frontend.brokers.advertise');
    }
    public function countryAadvertise(): View
    {
        return view('frontend.brokers.advertisecountry');
    }

    public function brokerRegistrationType(): View
    {
        return view('frontend.brokers.registration-select-login-type');
    }

    public function buyerRegistration(): View
    {
        return view('frontend.buyers.registration');
    }

    public function buyerRegistrationSelectLogin(): View
    {
        return view('frontend.buyers.registration-select-login');
    }

    public function buyerRegistrationForm(): View
    {
        return view('frontend.buyers.registrationform');
    }
    public function buyerRegistrationDetails(): View
    {
        return view('frontend.buyers.registrationformdetails');
    }
}
