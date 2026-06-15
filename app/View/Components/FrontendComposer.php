<?php

namespace App\View\Components;

use App\Enums\Country;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Support\CountryUtility;
use App\Models\Menu;
use App\Models\Business;

class FrontendComposer
{
    public function compose(View $view): void
    {
        // Header Menu
        $headerMenu = Menu::where('location', 'primary')
            ->with('items.children')
            ->first();

        // Footer Menu
        $footerMenu = Menu::where('location', 'like', 'footer%')
        ->with('items.children')
        ->get();

        $sellersMenu = Menu::where('location', 'sellers')
        ->with('items.children')
        ->first();


        $buyersMenu = Menu::where('location', 'buyers')
        ->with('items.children')
        ->first();

        $brokersMenu = Menu::where('location', 'broker')
        ->with('items.children')
        ->first();

        // Current country using unified CountryUtility
        $currentCountry = CountryUtility::currentCode();

        // Featured businesses
        $featuredBusinesses = Business::featured()
            ->limit(8)
            ->get();

        if ($featuredBusinesses->isEmpty()) {
            $featuredBusinesses = Business::active()
                ->latest()
                ->limit(8)
                ->get();
        }

        // Categories
        $businessCategories = Business::active()
            ->select('business_type', DB::raw('count(*) as total'))
            ->groupBy('business_type')
            ->having('total', '>', 0)
            ->limit(8)
            ->get();

        // Industries
        $businessIndustries = Business::active()
            ->select('industry', DB::raw('count(*) as total'))
            ->groupBy('industry')
            ->having('total', '>', 0)
            ->limit(8)
            ->get();

        // Total
        $totalBusinesses = Business::active()->count();

        $countries = collect(CountryUtility::all())->map(function (Country $country) {
            return (object) [
                'slug' => $country->value,
                'name' => $country->label(),
                'code' => $country->code(),
            ];
        });


        $hasCountrySubdomain = CountryUtility::hasSubdomain();
        $countryCode = CountryUtility::fromSubdomain()?->value;

        $view->with([
            'headerMenu' => $headerMenu,
            'footerMenu' => $footerMenu,
            'sellersMenu' => $sellersMenu,
            'buyersMenu' => $buyersMenu,
            'brokersMenu' => $brokersMenu,
            'featuredBusinesses' => $featuredBusinesses,
            'businessCategories' => $businessCategories,
            'businessIndustries' => $businessIndustries,
            'totalBusinesses' => $totalBusinesses,
            'currentCountry' => $currentCountry,
            'availableCountries' => $countries,
            'countries' => $countries,
            'hasCountrySubdomain' => $hasCountrySubdomain,
            'countryCode' => $countryCode,
        ]);
    }
}
