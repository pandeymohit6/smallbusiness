<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'title',
        'caption',
        'image_url',
        'sort_order',
    ];

    /**
     * Get the business that owns the gallery.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
