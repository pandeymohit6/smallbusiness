<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\CountryScope;
use Illuminate\Database\Eloquent\Model;

/**
 * Base model that automatically applies country filtering
 * Use this as parent class for models that have a country_code column
 */
class CountryAwareModel extends Model
{
    protected $fillable = ['country_code'];

    protected static function booted(): void
    {
        // Apply country filter to all queries
        static::addGlobalScope(new CountryScope());

        // Auto-assign country when creating
        static::creating(function ($model) {
            if (empty($model->country_code)) {
                $model->country_code = session('country', 'usa');
            }
        });
    }
}
