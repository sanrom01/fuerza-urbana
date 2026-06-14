<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    // Ver carrito
    public function index()
    {
        $carrito  = session('carrito', []);
        $subtotal = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);
        return view('shop.carrito', compact('carrito', 'subtotal'));
    }

    // Agregar producto al carrito
    public function agregar(Request $request, $id)
    {
        $producto = Product::findOrFail($id);
        $cantidad = max(1, (int) $request->cantidad);
        $carrito  = session('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            $carrito[$id] = [
                'nombre'   => $producto->name,
                'precio'   => $producto->sale_price ?? $producto->price,
                'cantidad' => $cantidad,
                'imagen'   => $producto->images->where('is_main', true)->first()?->url
                              ?? 'https://picsum.photos/seed/'.$id.'/200/200',
                'sku'      => $producto->sku,
            ];
        }

        session(['carrito' => $carrito]);

        return response()->json([
            'mensaje'  => 'Producto agregado al carrito.',
            'cantidad' => count($carrito),
        ]);
    }

    // Actualizar cantidad
    public function actualizar(Request $request, $id)
    {
        $carrito = session('carrito', []);
        if (isset($carrito[$id])) {
            if ($request->accion === 'sumar') {
                $carrito[$id]['cantidad']++;
            } elseif ($request->accion === 'restar' && $carrito[$id]['cantidad'] > 1) {
                $carrito[$id]['cantidad']--;
            }
        }
        session(['carrito' => $carrito]);
        return back();
    }

    // Eliminar un item
    public function eliminar($id)
    {
        $carrito = session('carrito', []);
        unset($carrito[$id]);
        session(['carrito' => $carrito]);
        return back()->with('success', 'Producto eliminado del carrito.');
    }

    // Vaciar carrito
    public function vaciar()
    {
        session()->forget('carrito');
        return back()->with('success', 'Carrito vaciado.');
    }
}
