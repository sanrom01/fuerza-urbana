<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address_id', 'status',
        'subtotal', 'shipping_cost', 'discount', 'total',
        'notes', 'tracking_code', 'shipped_at', 'delivered_at',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount'      => 'decimal:2',
        'total'         => 'decimal:2',
        'shipped_at'    => 'datetime',
        'delivered_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // ← Esta relación faltaba y causaba el error 500
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}