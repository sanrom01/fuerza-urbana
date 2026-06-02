<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'nombre', 'email', 'asunto',
        'mensaje', 'estado', 'respuesta', 'respondida_at',
    ];

    protected $casts = [
        'respondida_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}