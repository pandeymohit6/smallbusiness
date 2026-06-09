<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyerExperience extends Model
{
    protected $fillable = ['name', 'description', 'sort_order', 'is_active'];

    public function buyerRegistrations()
    {
        return $this->hasMany(BuyerRegistration::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
