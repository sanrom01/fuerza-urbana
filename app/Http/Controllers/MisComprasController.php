<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MisComprasController extends Controller
{
    public function index()
    {
        $ordenes = Order::with('items.product.images', 'payment')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(5);

        return view('Mis-compras', compact('ordenes'));
    }

    public function show($id)
    {
        $orden = Order::with('items.product.images', 'payment', 'address', 'factura')
                      ->where('user_id', Auth::id())
                      ->findOrFail($id);

        // Nombre correcto del archivo: mis_compras_detalle.blade.php
        return view('mis_compras_detalle', compact('orden'));
    }
}