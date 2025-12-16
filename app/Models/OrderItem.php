<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'prod_id',
        'price',
        'qty',
    ];

    /**
     * Get the product associated with the order item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'prod_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id'); // Adjust 'prod_id' if your foreign key is different
    }

    // Define the relationship to Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
// In OrderItem.php
public function returnRequest()
{
    return $this->hasOne(ReturnRequest::class, 'prod_id', 'prod_id'); // Match based on product ID
}
}
