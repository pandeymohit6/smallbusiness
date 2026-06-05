<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
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
        $footerMenu = Menu::where('location','!=', 'primary')
            ->with('items.children')
            ->get();

        // Current country
        $currentCountry = $this->getCurrentCountry();

        // Available countries
        $availableCountries = Business::active()
            ->select('country_code')
            ->distinct()
            ->whereNotNull('country_code')
            ->pluck('country_code');

        // Country names
        $countryNames = $this->getCountryNames();
        $formattedCountries = collect();

        foreach ($availableCountries as $code) {
            $formattedCountries->put(
                $code,
                $countryNames[$code] ?? $code
            );
        }

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

        $view->with([
            'headerMenu' => $headerMenu,
            'footerMenu' => $footerMenu,
            'featuredBusinesses' => $featuredBusinesses,
            'businessCategories' => $businessCategories,
            'businessIndustries' => $businessIndustries,
            'totalBusinesses' => $totalBusinesses,
            'currentCountry' => $currentCountry,
            'availableCountries' => $formattedCountries,
        ]);
    }

      /**
     * Get country name from country code mapping
     */
    private function getCountryNames(): array
    {
        return [
            'US' => 'United States',
            'CA' => 'Canada',
            'AU' => 'Australia',
        ];
    }

    /**
     * Get current country from subdomain or return default
     */
    private function getCurrentCountry(): ?string
    {
        // Get current host
        $host = request()->getHost();
        
        // Extract subdomain (country code)
        $parts = explode('.', $host);
        
        if (count($parts) > 2 && $parts[0] !== 'www') {
            // Return country code from subdomain (e.g., 'in' from 'in.localhost.com')
            return strtoupper($parts[0]);
        }
        
        // Return from session or default to null
        return session('country_code');
    }
}