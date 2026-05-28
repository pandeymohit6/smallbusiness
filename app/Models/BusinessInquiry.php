<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'broker_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'replied_at',
        'reply_message',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Get the business that owns the inquiry.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function broker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'broker_id');
    }

    /**
     * Mark the inquiry as replied.
     */
    public function markAsReplied(string $message): void
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now(),
            'reply_message' => $message,
        ]);
    }

    /**
     * Get inquiry statuses.
     */
    public static function getStatuses(): array
    {
        return [
            'pending' => __('Pending'),
            'replied' => __('Replied'),
            'archived' => __('Archived'),
        ];
    }
}
