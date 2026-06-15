<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\QueryBuilderTrait;
use App\Concerns\HasMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Business extends CountryAwareModel implements SpatieHasMedia
{
    use HasFactory;
    use QueryBuilderTrait;
    use HasMedia;
    use SoftDeletes;

    protected $fillable = [
        "uuid",
        'user_id',
        'title',
        'slug',
        'description',
        'overview',
        'business_type',
        'industry',
        'location',
        'country_code',
        'state',
        'city',
        'asking_price',
        'annual_revenue',
        'annual_profit',
        'years_in_operation',
        'employees',
        'status',
        'current_step',
        'listing_headline',
        'general_summary',
        'business_status',
        'category',
        'region',
        'property_status',
        'asking_price_range',
        'specific_asking_price',
        'asking_price_on_request',
        'quick_sale_negotiable',
        'revenue_range',
        'specific_revenue',
        'revenue_on_request',
        'cash_flow_range',
        'specific_cash_flow',
        'cash_flow_on_request',
        'photographs',
        'documents',
        'website_address',
        'embed_video',
        'location_details',
        'premises_details',
        'competition',
        'expansion_potential',
        'accommodation_included',
        'accommodation_description',
        'property_size_sqft',
        'planning_consent',
        'years_established',
        'management_type',
        'employees_details',
        'trading_hours',
        'support_training',
        'e2_visa_eligible',
        'relocatable',
        'can_run_from_home',
        'is_franchise',
        'franchise_terms',
        'not_operating',
        'turnaround_opportunity',
        'willing_to_finance',
        'financing_available',
        'reason_for_selling',
        'furniture_included',
        'furniture_value',
        'inventory_included',
        'inventory_value',
        'selected_package',
        'draft_saved_at',
        'meta',
        'features',
        'highlights',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'photographs' => 'array',
        'documents' => 'array',
        'asking_price' => 'decimal:2',
        'annual_revenue' => 'decimal:2',
        'annual_profit' => 'decimal:2',
        'furniture_value' => 'decimal:2',
        'inventory_value' => 'decimal:2',
        'asking_price_on_request' => 'boolean',
        'quick_sale_negotiable' => 'boolean',
        'revenue_on_request' => 'boolean',
        'cash_flow_on_request' => 'boolean',
        'accommodation_included' => 'boolean',
        'e2_visa_eligible' => 'boolean',
        'relocatable' => 'boolean',
        'can_run_from_home' => 'boolean',
        'is_franchise' => 'boolean',
        'not_operating' => 'boolean',
        'turnaround_opportunity' => 'boolean',
        'willing_to_finance' => 'boolean',
        'furniture_included' => 'boolean',
        'inventory_included' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'draft_saved_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Business $business) {
            if (empty($business->slug)) {
                $business->slug = static::uniqueSlug($business->title);
            }

            if (empty($business->user_id) && Auth::check()) {
                $business->user_id = Auth::id();
            }
        });
    }

    protected static function uniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the user that owns the business.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gallery images for the business.
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(BusinessGallery::class)->orderBy('sort_order');
    }

    /**
     * Get the inquiries for the business.
     */
    public function inquiries(): HasMany
    {
        return $this->hasMany(BusinessInquiry::class);
    }

    /**
     * Get pending inquiries.
     */
    public function pendingInquiries(): HasMany
    {
        return $this->inquiries()->where('status', 'pending');
    }

    /**
     * Scope to get only active businesses.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope to get only featured businesses.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->active();
    }

    /**
     * Scope to filter by business type.
     */
    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('business_type', $type);
    }

    /**
     * Scope to filter by industry.
     */
    public function scopeByIndustry(Builder $query, string $industry): Builder
    {
        return $query->where('industry', $industry);
    }

    /**
     * Scope to filter by location.
     */
    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', 'like', '%' . $location . '%');
    }

    /**
     * Scope to filter by price range.
     */
    public function scopeByPriceRange(Builder $query, float $min, float $max): Builder
    {
        return $query->whereBetween('asking_price', [$min, $max]);
    }

    /**
     * Scope to filter by country.
     */
    public function scopeByCountry(Builder $query, string $country): Builder
    {
        return $query->where('country_code', $country);
    }

    /**
     * Scope to filter by state.
     */
    public function scopeByState(Builder $query, string $state): Builder
    {
        return $query->where('state', $state);
    }

    /**
     * Scope to filter by city.
     */
    public function scopeByCity(Builder $query, string $city): Builder
    {
        return $query->where('city', $city);
    }

    /**
     * Scope to filter by country and state.
     */
    public function scopeByCountryAndState(Builder $query, string $country, string $state): Builder
    {
        return $query->where('country_code', $country)->where('state', $state);
    }

    /**
     * Scope to filter by country, state, and city.
     */
    public function scopeByCountryStateCity(Builder $query, string $country, string $state, string $city): Builder
    {
        return $query->where('country_code', $country)
            ->where('state', $state)
            ->where('city', $city);
    }

    /**
     * Get business statuses.
     */
    public static function getStatuses(): array
    {
        return [
            'draft' => __('Draft'),
            'active' => __('Active'),
            'sold' => __('Sold'),
            'delisted' => __('Delisted'),
        ];
    }

    /**
     * Get business types.
     */
    public static function getBusinessTypes(): array
    {
        return [
            'retail' => __('Retail'),
            'service' => __('Service'),
            'restaurant' => __('Restaurant'),
            'e_commerce' => __('E-commerce'),
            'software' => __('Software'),
            'manufacturing' => __('Manufacturing'),
            'hospitality' => __('Hospitality'),
            'real_estate' => __('Real Estate'),
            'consulting' => __('Consulting'),
            'other' => __('Other'),
        ];
    }

    /**
     * Get industries.
     */
    public static function getIndustries(): array
    {
        return [
            'technology' => __('Technology'),
            'finance' => __('Finance'),
            'healthcare' => __('Healthcare'),
            'education' => __('Education'),
            'food_beverage' => __('Food & Beverage'),
            'retail' => __('Retail'),
            'manufacturing' => __('Manufacturing'),
            'real_estate' => __('Real Estate'),
            'automotive' => __('Automotive'),
            'entertainment' => __('Entertainment'),
            'other' => __('Other'),
        ];
    }

    /**
     * Get countries list.
     */
    public static function getCountries(): array
    {
        return [
            'United States' => __('United States'),
            'Canada' => __('Canada'),
            'Australia' => __('Australia'),
        ];
    }

    /**
     * Get states by country.
     */
    public static function getStatesByCountry(string $country): array
    {
        $states = [
            'United States' => [
                'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
                'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
                'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
                'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
                'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
                'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
                'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
                'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
                'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
                'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
                'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
                'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
                'WI' => 'Wisconsin', 'WY' => 'Wyoming', 'DC' => 'District of Columbia',
            ],
            'Canada' => [
                'AB' => 'Alberta', 'BC' => 'British Columbia', 'MB' => 'Manitoba',
                'NB' => 'New Brunswick', 'NL' => 'Newfoundland and Labrador', 'NS' => 'Nova Scotia',
                'NT' => 'Northwest Territories', 'NU' => 'Nunavut', 'ON' => 'Ontario',
                'PE' => 'Prince Edward Island', 'QC' => 'Quebec', 'SK' => 'Saskatchewan',
                'YT' => 'Yukon',
            ],
            'Australia' => [
                'NSW' => 'New South Wales', 'QLD' => 'Queensland', 'SA' => 'South Australia',
                'TAS' => 'Tasmania', 'VIC' => 'Victoria', 'WA' => 'Western Australia',
                'ACT' => 'Australian Capital Territory', 'NT' => 'Northern Territory',
            ],
        ];

        return $states[$country] ?? [];
    }

    /**
     * Get cities by country and state (simplified - can be extended with database).
     */
    public static function getCitiesByCountryAndState(string $country, string $state): array
    {
        // This is a simplified list. In production, you might want to fetch from a cities database.
        $cities = [
            'United States' => [
                'CA' => ['Los Angeles', 'San Francisco', 'San Diego', 'Sacramento', 'San Jose'],
                'NY' => ['New York', 'Buffalo', 'Rochester', 'Yonkers', 'Albany'],
                'TX' => ['Houston', 'Dallas', 'Austin', 'San Antonio', 'Fort Worth'],
                'FL' => ['Miami', 'Orlando', 'Tampa', 'Jacksonville', 'Fort Lauderdale'],
                // Add more states as needed
            ],
            'Canada' => [
                'ON' => ['Toronto', 'Ottawa', 'Hamilton', 'London', 'Kitchener'],
                'QC' => ['Montreal', 'Quebec City', 'Laval', 'Gatineau', 'Longueuil'],
                'BC' => ['Vancouver', 'Victoria', 'Surrey', 'Burnaby', 'Coquitlam'],
                'AB' => ['Calgary', 'Edmonton', 'Red Deer', 'Lethbridge', 'Medicine Hat'],
                // Add more provinces as needed
            ],
            'Australia' => [
                'NSW' => ['Sydney', 'Newcastle', 'Wollongong', 'Central Coast', 'Lismore'],
                'VIC' => ['Melbourne', 'Geelong', 'Ballarat', 'Bendigo', 'Echuca'],
                'QLD' => ['Brisbane', 'Gold Coast', 'Sunshine Coast', 'Cairns', 'Townsville'],
                'WA' => ['Perth', 'Fremantle', 'Mandurah', 'Bunbury', 'Geraldton'],
                // Add more states as needed
            ],
        ];

        return $cities[$country][$state] ?? [];
    }

    function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
}
