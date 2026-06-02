<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class CountryScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * NOTE: This scope no longer applies automatic filtering based on subdomain.
     * Filtering by country/state/city is now done explicitly using the
     * byCountry(), byState(), byCity() scopes or the byCountryStateCity() scope.
     *
     * This scope is kept for backward compatibility but doesn't filter queries automatically.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // No automatic filtering - use explicit scopes instead
        // Example: Business::byCountry('United States')->byState('CA')->get()
    }
}
