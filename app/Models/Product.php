<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'cate_id',
        'name',
        'slug',
        'small_description',
        'description',
        'original_price',
        'selling_price',
        'image',
        'tax',
        'qty',
        'status',
        'trending',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'view_count',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id', 'id');
    }
    public function reviews()
{
    return $this->hasMany(Review::class, 'prod_id', 'id');
}

public function ratings()
{
    return $this->hasMany(Rating::class, 'prod_id', 'id');
}

public function averageRating()
{
    return $this->ratings()->avg('stars_rated');
}

public function reviewCount()
{
    return $this->reviews()->count();
}
// In App\Models\Product.php

public function orders()
{
    return $this->hasMany(Order::class);
}
public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'prod_id'); // Adjust 'prod_id' if your foreign key is different
}
}
