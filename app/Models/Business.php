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

class Business extends Model implements SpatieHasMedia
{
    use HasFactory;
    use QueryBuilderTrait;
    use HasMedia;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'overview',
        'business_type',
        'industry',
        'location',
        'asking_price',
        'annual_revenue',
        'annual_profit',
        'years_in_operation',
        'employees',
        'status',
        'meta',
        'features',
        'highlights',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'asking_price' => 'decimal:2',
        'annual_revenue' => 'decimal:2',
        'annual_profit' => 'decimal:2',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Business $business) {
            if (empty($business->slug)) {
                $business->slug = Str::slug($business->title);
            }

            if (empty($business->user_id) && Auth::check()) {
                $business->user_id = Auth::id();
            }
        });
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
}
