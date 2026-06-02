<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Menu;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(): View
    {
        // Fetch dynamic navigation menu
        $headerMenu = Menu::where('location', 'primary')
            ->with('items.children')
            ->first();

        // Detect current country from subdomain or session
        $currentCountry = $this->getCurrentCountry();
        
        // Get all available countries from businesses (using country_code)
        $availableCountries = Business::active()
            ->select('country_code')
            ->distinct()
            ->whereNotNull('country_code')
            ->pluck('country_code');

        // Country code to name mapping
        $countryNames = $this->getCountryNames();
        
        // Format countries for header display
        $formattedCountries = collect();
        foreach ($availableCountries as $code) {
            $formattedCountries->put($code, $countryNames[$code] ?? $code);
        }

        // Fetch featured businesses
        $featuredBusinesses = Business::featured()
            ->limit(8)
            ->get();

        // If no featured businesses, get latest active businesses
        if ($featuredBusinesses->isEmpty()) {
            $featuredBusinesses = Business::active()
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        }

        // Fetch business types/categories with counts
        $businessCategories = Business::active()
            ->select('business_type', DB::raw('count(*) as total'))
            ->groupBy('business_type')
            ->having('total', '>', 0)
            ->limit(8)
            ->get();

        // Fetch industries with counts
        $businessIndustries = Business::active()
            ->select('industry', DB::raw('count(*) as total'))
            ->groupBy('industry')
            ->having('total', '>', 0)
            ->limit(8)
            ->get();

        // Get total business count
        $totalBusinesses = Business::active()->count();

        return view('frontend.home', [
            'headerMenu' => $headerMenu,
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
            'IN' => 'India',
            'UK' => 'United Kingdom',
            'GB' => 'United Kingdom',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'NZ' => 'New Zealand',
            'DE' => 'Germany',
            'FR' => 'France',
            'ES' => 'Spain',
            'IT' => 'Italy',
            'JP' => 'Japan',
            'CN' => 'China',
            'BR' => 'Brazil',
            'MX' => 'Mexico',
            'ZA' => 'South Africa',
            'SG' => 'Singapore',
            'HK' => 'Hong Kong',
            'AE' => 'United Arab Emirates',
            'KR' => 'South Korea',
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

    public function loginPage(): View
    {
        return view('frontend.login');
    }

    public function registerPage(): View
    {
        return view('frontend.register');
    }
}
