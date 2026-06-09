<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BusinessBuyer extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_code',
        'phone',
        'country',
        'buyer_type',
        'buyer_experience',
        'newsletter',
        'third_party_email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}