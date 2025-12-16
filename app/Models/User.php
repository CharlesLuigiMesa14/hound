<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'lname', 'email', 'password', 'phone', 'address1', 'address2', 'city', 'state', 'country', 'pincode', 'role_as', 'social_id', 'auth_provider','auth_provider_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getTotalPurchasesAttribute()
    {
        return $this->orders()->sum('total_price');
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->lname}";
    }

    // Check if the user is an admin
    public function isAdmin()
    {
        return $this->role_as === 'admin';
    }
    protected $dates = ['last_active_at'];
}