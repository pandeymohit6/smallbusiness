<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Country;
use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'code',
        'name',
        'label',
        'currency',
        'timezone',
        'locale',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get country from code
     */
    public static function byCode(string $code): ?self
    {
        return self::where('code', $code)->first();
    }

    /**
     * Get active countries
     */
    public static function active()
    {
        return self::where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Seed default countries
     */
    public static function seedDefaults(): void
    {
        foreach (Country::all() as $country) {
            self::updateOrCreate(
                ['code' => $country->value],
                [
                    'name' => $country->label(),
                    'label' => $country->label(),
                    'currency' => $country->currency(),
                    'is_active' => true,
                ]
            );
        }
    }
}
