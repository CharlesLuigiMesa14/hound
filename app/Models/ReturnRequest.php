<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'prod_id',
        'qty',
        'return_reason',
        'images',
        'return_status',
        'comment',
        'return_response', // Make return_response fillable
        'refund_amount', // Add refund_amount to fillable
        'refund_status', // Add refund_status to fillable
        'refund_date', // Add this line
    ];

    // Define relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id');
    }
}