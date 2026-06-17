<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'sku',
        'price', 'sale_price', 'stock', 'stock_min', 'is_active', 'featured',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active'  => 'boolean',
        'featured'   => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relación con talles y su stock
    public function talles()
    {
        return $this->hasMany(ProductTalle::class);
    }

    // Stock de un talle específico
    public function stockTalle(string $talle): int
    {
        return $this->talles->where('talle', $talle)->first()?->stock ?? 0;
    }

    // Stock total del producto (suma de todos los talles)
    // Si no tiene talles definidos usa el stock general
    public function stockTotal(): int
    {
        if ($this->talles->isEmpty()) {
            return $this->stock;
        }
        return $this->talles->sum('stock');
    }
}