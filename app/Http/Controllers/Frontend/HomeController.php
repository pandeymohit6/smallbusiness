<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the home page
     */
    public function index(): View
    {
        return view('frontend.home');
    }

    /**
     * Show a generic page by slug
     */
    public function getPages(string $slug): View
    {
        $pages = Post::where('slug', $slug)->firstOrFail();
        return view('frontend.pages', compact('pages'));
    }

    /**
     * Show the buy a business page
     */
    public function buyABusiness(): View
    {
        return view('frontend.buy-a-business');
    }

    /**
     * Kept for backward compatibility - redirects to seller index
     * @deprecated Use SellerController@index instead
     */
    public function sellYourBusiness(): View
    {
        return view('frontend.sellers.sell-your-business');
    }

    /**
     * Kept for backward compatibility - redirects to buyer index
     * @deprecated Use BuyerController@index instead
     */
    public function buyerRegistration(): View
    {
        return view('frontend.buyers.registration');
    }

    /**
     * Kept for backward compatibility - redirects to broker index
     * @deprecated Use BrokerController@index instead
     */
    public function advertise(): View
    {
        return view('frontend.brokers.advertise');
    }

    public function comingsoon(): View
    {
        return view('frontend.comingsoon');
    }

    public function emailAlertsInfo(): View
    {
        return view('frontend.email-alerts-info');
    }

    public function sellerBeware(): View
    {
        return view('frontend.sellerbeware');
    }

    public function buyerBeware(): View
    {
        return view('frontend.buyerbeware');
    }

    public function contact(): View
    {
        return view('frontend.contact');
    }
}
