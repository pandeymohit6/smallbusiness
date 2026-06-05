<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\CountryScope;
use Illuminate\Database\Eloquent\Model;

class CountryAwareModel extends Model
{
    protected $fillable = ['country_code'];

    protected static function booted(): void
    {
        // Apply global country scope
        static::addGlobalScope(new CountryScope());

        // Auto assign country_code
        static::creating(function ($model) {

            if (empty($model->country_code)) {

                $countryCode =
                    session('country')
                    ?? static::detectCountryFromSubdomain()
                    ?? static::detectCountryFromGeoIp()
                    ?? config('app.default_country', 'us');

                $countryCode = strtolower($countryCode);

                // Save in session for reuse
                session(['country' => $countryCode]);

                $model->country_code = $countryCode;
            }
        });
    }

    /**
     * Detect from subdomain
     * usa.domain.com / in.domain.com / au.domain.com
     */
    protected static function detectCountryFromSubdomain(): ?string
    {
        $host = request()->getHost();
        $parts = explode('.', $host);

        if (count($parts) > 2) {
            return strtolower($parts[0]);
        }

        return null;
    }

    /**
     * Detect using GeoIP
     */
    protected static function detectCountryFromGeoIp(): ?string
    {
        try {

            if (function_exists('geoip')) {

                $country = geoip(request()->ip());

                return $country?->iso_code
                    ? strtolower($country->iso_code)
                    : null;
            }

        } catch (\Throwable $e) {
            report($e);
        }

        return null;
    }
}