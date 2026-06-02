<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Country;
use Illuminate\Support\Facades\Session;

class MultiCountryService
{
    /**
     * Get the current country from session (if viewing country-specific site)
     * Returns null if on main localhost (viewing all countries)
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
     * Get the current country value string ('usa', 'canada', 'aus') or null
     */
    public static function currentValue(): ?string
    {
        return self::current()?->value;
    }

    /**
     * Check if currently filtered to a specific country
     */
    public static function is(Country $country): bool
    {
        return self::current() === $country;
    }

    /**
     * Check if viewing all countries (on main localhost without country filter)
     */
    public static function isViewingAll(): bool
    {
        return self::current() === null;
    }

    /**
     * Get all available countries
     */
    public static function all(): array
    {
        return Country::all();
    }

    /**
     * Get country URL
     */
    public static function url(Country $country, string $path = '/'): string
    {
        $baseDomain = config('app.base_domain');
        $protocol = parse_url(config('app.url'), PHP_URL_SCHEME) ?? 'https';
        $port = request()->getPort() !== 80 && request()->getPort() !== 443 
            ? ':' . request()->getPort() 
            : '';
        
        return "{$protocol}://{$country->value}.{$baseDomain}{$port}{$path}";
    }

    /**
     * Get main/all countries URL
     */
    public static function mainUrl(string $path = '/'): string
    {
        $baseDomain = config('app.base_domain');
        $protocol = parse_url(config('app.url'), PHP_URL_SCHEME) ?? 'https';
        $port = request()->getPort() !== 80 && request()->getPort() !== 443 
            ? ':' . request()->getPort() 
            : '';
        
        return "{$protocol}://{$baseDomain}{$port}{$path}";
    }

    /**
     * Get country details
     */
    public static function details(Country $country): array
    {
        return [
            'name' => $country->label(),
            'code' => $country->code(),
            'currency' => $country->currency(),
            'value' => $country->value,
        ];
    }

    /**
     * Get all countries with details
     */
    public static function allWithDetails(): array
    {
        return collect(Country::all())
            ->mapWithKeys(fn ($country) => [
                $country->value => self::details($country),
            ])
            ->toArray();
    }
}
