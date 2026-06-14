<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito  = session('carrito', []);
        $subtotal = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);
        return view('Carrito', compact('carrito', 'subtotal'));
    }

    public function agregar(Request $request, $id)
    {
        $producto = Product::with('images')->findOrFail($id);
        $cantidad = max(1, (int) $request->cantidad);
        $talle    = $request->talle ?? 'Único';
        $carrito  = session('carrito', []);

        $key = $id . '_' . $talle;

        if (isset($carrito[$key])) {
            $carrito[$key]['cantidad'] += $cantidad;
        } else {
            $carrito[$key] = [
                'producto_id' => (int) $id,
                'nombre'      => $producto->name,
                'precio'      => (float) ($producto->sale_price ?? $producto->price),
                'cantidad'    => $cantidad,
                'talle'       => $talle,
                'imagen'      => $producto->images->where('is_main', true)->first()?->url ?? '',
                'sku'         => $producto->sku ?? '',
            ];
        }

        session(['carrito' => $carrito]);

        return response()->json([
            'ok'       => true,
            'mensaje'  => 'Producto agregado.',
            'cantidad' => count($carrito),
        ]);
    }

    public function actualizar(Request $request, $key)
    {
        $carrito = session('carrito', []);
        if (isset($carrito[$key])) {
            if ($request->accion === 'sumar') {
                $carrito[$key]['cantidad']++;
            } elseif ($request->accion === 'restar' && $carrito[$key]['cantidad'] > 1) {
                $carrito[$key]['cantidad']--;
            }
            session(['carrito' => $carrito]);
        }
        return back();
    }

    public function eliminar($key)
    {
        $carrito = session('carrito', []);
        unset($carrito[$key]);
        session(['carrito' => $carrito]);
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return back()->with('success', 'Carrito vaciado.');
    }
}