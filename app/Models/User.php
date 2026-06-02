<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\AuthorizationChecker;
use App\Concerns\QueryBuilderTrait;
use App\Enums\Hooks\UserFilterHook;
use App\Support\Facades\Hook;
use App\Notifications\AdminResetPasswordNotification;
use App\Notifications\CustomVerifyEmailNotification;
use App\Observers\UserObserver;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Auth\Notifications\ResetPassword as DefaultResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Scopes\CountryScope;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements MustVerifyEmail
{
    use AuthorizationChecker;
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use MustVerifyEmailTrait;
    use Notifiable;
    use QueryBuilderTrait;

    protected static function booted(): void
    {
        // Apply country filter to user queries
        static::addGlobalScope(new CountryScope());
        
        // Auto-assign country when creating users
        static::creating(function ($model) {
            if (empty($model->country_code)) {
                $model->country_code = session('country', 'usa');
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'username',
        'avatar_id',
        'email_subscribed',
        'country_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Allow modules to extend fillable fields without touching this file.
     */
    public function getFillable(): array
    {
        return Hook::applyFilters(UserFilterHook::USER_FILLABLE, $this->fillable);
    }

    /**
     * Allow modules to extend attribute casts without touching this file.
     */
    public function getCasts(): array
    {
        return Hook::applyFilters(UserFilterHook::USER_CASTS, parent::getCasts());
    }

    /**
     * The attributes that should be appended to the model.
     */
    protected $appends = [
        'avatar_url',
        'full_name',
    ];

    /**
     * The relationships that should be eager loaded.
     */
    protected $with = [
        'avatar',
    ];

    public function actionLogs(): HasMany
    {
        return $this->hasMany(ActionLog::class, 'action_by');
    }

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Get the user's metadata.
     */
    public function userMeta(): HasMany
    {
        return $this->hasMany(UserMeta::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token): void
    {
        // Check if the request is for the admin panel
        if (request()->is('admin/*')) {
            $this->notify(new AdminResetPasswordNotification($token));
        } else {
            $this->notify(new DefaultResetPassword($token));
        }
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmailNotification());
    }

    /**
     * Check if the user has any of the given permissions.
     *
     * @param  array|string  $permissions
     */
    public function hasAnyPermission($permissions): bool
    {
        if (empty($permissions)) {
            return true;
        }

        $permissions = is_array($permissions) ? $permissions : [$permissions];

        foreach ($permissions as $permission) {
            if ($this->can($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the user's avatar media.
     */
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'avatar_id', 'id');
    }

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_id) {
            return asset('storage/media/' . $this->avatar->file_name);
        }

        return $this->getGravatarUrl();
    }

    /**
     * Get the Gravatar URL for the model's email.
     */
    public function getGravatarUrl(int $size = 80): string
    {
        if (! empty($this->avatar_id)) {
            return asset('storage/media/' . $this->avatar->file_name);
        }

        // Generate local avatar initials instead of using external API
        $initials = collect(explode(' ', $this->full_name ?? 'U'))
            ->take(2)
            ->map(fn($name) => strtoupper(substr($name, 0, 1)))
            ->join('');

        $brandColor = ltrim(config('settings.theme_primary_color', '#635bff'), '#');
        
        // Return data URI for initials avatar or use placeholder
        return $this->generateInitialsAvatar($initials, $brandColor, $size);
    }

    /**
     * Generate a local avatar with initials
     */
    private function generateInitialsAvatar(string $initials, string $color, int $size = 32): string
    {
        // Return a simple colored square with initials using SVG data URI
        $svg = sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 %d %d"><rect fill="#%s" width="%d" height="%d"/><text x="50%%" y="50%%" font-size="%d" fill="#fff" text-anchor="middle" dy=".3em" font-family="sans-serif" font-weight="bold">%s</text></svg>',
            $size,
            $size,
            $color,
            $size,
            $size,
            $size * 0.5,
            htmlspecialchars($initials)
        );
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
