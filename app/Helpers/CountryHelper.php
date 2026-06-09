<?php

use App\Support\CountryUtility;
use App\Enums\Country;

/**
 * Get current country ISO code (e.g., 'US', 'CA', 'AU')
 * 
 * @deprecated Use CountryUtility::currentCode() instead
 */
if (!function_exists('country_code')) {
    function country_code(): ?string
    {
        return CountryUtility::currentCode();
    }
}

/**
 * Get current country subdomain value (e.g., 'usa', 'canada', 'aus')
 * 
 * @deprecated Use CountryUtility::currentValue() instead
 */
if (!function_exists('country_subdomain')) {
    function country_subdomain(): ?string
    {
        return CountryUtility::currentValue();
    }
}

/**
 * Get country code from subdomain (helper for requests)
 */
if (!function_exists('country_code_from_subdomain')) {
    function country_code_from_subdomain(): ?string
    {
        $country = CountryUtility::fromSubdomain();
        return $country?->code();
    }
}

/**
 * Check if viewing specific country subdomain
 */
if (!function_exists('has_country_subdomain')) {
    function has_country_subdomain(): bool
    {
        return CountryUtility::hasSubdomain();
    }
}