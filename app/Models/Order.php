<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    
    protected $fillable = [
        'user_id',
        'fname',
        'lname',
        'email',
        'phone',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'pincode',
        'total_price',
        'payment_mode',
        'payment_id',
        'status',
        'message',
        'tracking_no',
    ];

    /**
     * Get the order items for the order.
     */
    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function totalAmount()
{
    return $this->orderitems()->sum('price');
}
// In App\Models\Order.php

public function product()
{
    return $this->belongsTo(Product::class);
}
public function coupon()
{
    return $this->belongsTo(Coupon::class, 'applied_coupon');
}
public function products()
{
    return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'prod_id'); // Adjust this based on your actual pivot table
}
}