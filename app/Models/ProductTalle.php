<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTalle extends Model
{
    protected $table = 'product_talles';

    protected $fillable = ['product_id', 'talle', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}