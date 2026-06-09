<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\Country;
use Illuminate\Support\Facades\Session;

/**
 * Centralized utility for handling country-related operations
 * Ensures consistent handling of country values across the application
 */
class CountryUtility
{
    /**
     * Get current country from session/request
     */
    public static function current(): ?Country
    {
        $country = Session::get('country') ?? request()->attributes->get('country');
        if ($country) {
            return Country::tryFrom($country);
        }
        
        return null;
    }

    /**
     * Get current country value ('usa', 'canada', 'aus')
     */
    public static function currentValue(): ?string
    {
        return self::current()?->value;
    }

    /**
     * Get current country label ('United States', 'Canada', 'Australia')
     */
    public static function currentLabel(): ?string
    {
        return self::current()?->label();
    }

    /**
     * Get current country ISO code ('US', 'CA', 'AU')
     */
    public static function currentCode(): ?string
    {
        return self::current()?->code();
    }

    /**
     * Check if user is viewing a specific country
     */
    public static function is(Country $country): bool
    {
        return self::current() === $country;
    }

    /**
     * Check if viewing all countries (main domain without subdomain)
     */
    public static function isViewingAll(): bool
    {
        return self::current() === null;
    }

    /**
     * Normalize country input to enum value
     * Accepts: 'usa', 'USA', 'United States', 'US', etc.
     */
    public static function normalize(?string $input): ?string
    {
        if (!$input) {
            return null;
        }

        $input = trim(strtolower($input));

        // Already a valid enum value
        if (in_array($input, Country::values())) {
            return $input;
        }

        // Try to match by label
        $fromLabel = Country::fromLabel(ucwords($input));
        if ($fromLabel) {
            return $fromLabel->value;
        }

        // Try to match by code
        $fromCode = Country::fromCode($input);
        if ($fromCode) {
            return $fromCode->value;
        }

        return null;
    }

    /**
     * Convert any country representation to Country enum
     */
    public static function toEnum(?string $input): ?Country
    {
        $normalized = self::normalize($input);
        return $normalized ? Country::tryFrom($normalized) : null;
    }

    /**
     * Get country label from any representation
     */
    public static function getLabel(?string $input): ?string
    {
        return self::toEnum($input)?->label();
    }

    /**
     * Get country value from any representation
     */
    public static function getValue(?string $input): ?string
    {
        return self::toEnum($input)?->value;
    }

    /**
     * Get country code from any representation
     */
    public static function getCode(?string $input): ?string
    {
        return self::toEnum($input)?->code();
    }

    /**
     * Get country currency from any representation
     */
    public static function getCurrency(?string $input): ?string
    {
        return self::toEnum($input)?->currency();
    }

    /**
     * Get all countries
     */
    public static function all(): array
    {
        return Country::all();
    }

    /**
     * Get all country values for database queries
     */
    public static function allValues(): array
    {
        return Country::values();
    }

    /**
     * Get all countries with full details
     */
    public static function allWithDetails(): array
    {
        return Country::allAsArray();
    }

    /**
     * Get select options for form dropdowns
     * Returns ['usa' => 'United States', 'canada' => 'Canada', ...]
     */
    public static function selectOptions(): array
    {
        return Country::selectOptions();
    }

    /**
     * Get validation rule for country_code field
     */
    public static function validationRule(): string
    {
        $values = implode(',', Country::values());
        return "in:{$values}";
    }

    /**
     * Get array for whereIn queries
     */
    public static function whereInArray(): array
    {
        return Country::values();
    }

    /**
     * Format location string with country, state, city
     */
    public static function formatLocation(?string $country, ?string $state = null, ?string $city = null): string
    {
        $parts = [];

        if ($city) {
            $parts[] = $city;
        }

        if ($state) {
            $parts[] = $state;
        }

        if ($country) {
            $countryLabel = self::getLabel($country) ?? $country;
            $parts[] = $countryLabel;
        }

        return implode(', ', array_filter($parts));
    }

    /**
     * Get country from subdomain
     */
    public static function fromSubdomain(): ?Country
    {
        $host = request()->getHost();
        $subdomain = strtolower(explode('.', $host)[0]);
        return Country::tryFrom($subdomain);
    }

    /**
     * Check if request is from country-specific subdomain
     */
    public static function hasSubdomain(): bool
    {
        return self::fromSubdomain() !== null;
    }
}
