<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_amount',
        'discount_type',
        'start_date',
        'end_date',
        'max_usage',
        'max_usage_per_user',
        'min_checkout_amount',
        'name', 
        'description', 
        'usage_count',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_product');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user')->withTimestamps();
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('Y-m-d H:i') : 'N/A';
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('Y-m-d H:i') : 'N/A';
    }

    public function isValid()
    {
        $now = now();
        return ($this->start_date === null || $this->start_date <= $now) &&
               ($this->end_date === null || $this->end_date >= $now);
    }

    public function canBeUsed()
    {
        return $this->usage_count < $this->max_usage;
    }

    public function canBeUsedByUser($userId)
    {
        $userUsageCount = $this->users()->where('user_id', $userId)->count();
        return $userUsageCount < $this->max_usage_per_user;
    }
}