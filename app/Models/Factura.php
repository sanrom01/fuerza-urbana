<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero', 'order_id', 'user_id',
        'subtotal', 'impuestos', 'total', 'estado', 'pdf_path',
    ];

    protected $casts = [
        'subtotal'   => 'decimal:2',
        'impuestos'  => 'decimal:2',
        'total'      => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Genera número correlativo: FAC-00001
    public static function generarNumero(): string
    {
        $ultimo = static::withTrashed()->max('id') ?? 0;
        return 'FAC-' . str_pad($ultimo + 1, 5, '0', STR_PAD_LEFT);
    }
}