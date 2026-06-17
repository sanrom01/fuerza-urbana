<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    protected $table = 'carritos';

    protected $fillable = [
        'user_id', 'producto_id', 'nombre',
        'precio', 'cantidad', 'talle', 'imagen', 'sku',
    ];

    public function producto()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}