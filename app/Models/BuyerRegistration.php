<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerRegistration extends Model
{
    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'phone',
        'country_id',
        'buyer_type_id',
        'buyer_experience_id',
        'newsletter',
        'third_party_emails',
        'status'
    ];

    protected $casts = [
        'newsletter' => 'boolean',
        'third_party_emails' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function buyerType()
    {
        return $this->belongsTo(BuyerType::class);
    }

    public function buyerExperience()
    {
        return $this->belongsTo(BuyerExperience::class);
    }
}
