<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTalle;
use App\Models\CarritoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // ── HELPERS ───────────────────────────────────────────────

    private function itemsDesdeDB(): array
    {
        return CarritoItem::where('user_id', Auth::id())
                          ->get()
                          ->keyBy(fn($i) => $i->producto_id . '_' . $i->talle)
                          ->map(fn($i) => [
                              'producto_id' => $i->producto_id,
                              'nombre'      => $i->nombre,
                              'precio'      => (float) $i->precio,
                              'cantidad'    => $i->cantidad,
                              'talle'       => $i->talle,
                              'imagen'      => $i->imagen,
                              'sku'         => $i->sku,
                          ])
                          ->toArray();
    }

    private function cargarCarrito(): array
    {
        if (Auth::check()) {
            $carritoDB = $this->itemsDesdeDB();
            $sesion = session('carrito', []);
            if (!empty($sesion)) {
                foreach ($sesion as $item) {
                    $this->guardarEnDB($item);
                }
                session()->forget('carrito');
                return $this->itemsDesdeDB();
            }
            return $carritoDB;
        }
        return session('carrito', []);
    }

    private function guardarEnDB(array $item): void
    {
        $existente = CarritoItem::where('user_id', Auth::id())
                                ->where('producto_id', $item['producto_id'])
                                ->where('talle', $item['talle'])
                                ->first();

        if ($existente) {
            $existente->increment('cantidad', $item['cantidad']);
        } else {
            CarritoItem::create([
                'user_id'     => Auth::id(),
                'producto_id' => $item['producto_id'],
                'nombre'      => $item['nombre'],
                'precio'      => $item['precio'],
                'cantidad'    => $item['cantidad'],
                'talle'       => $item['talle'],
                'imagen'      => $item['imagen'],
                'sku'         => $item['sku'] ?? '',
            ]);
        }
    }

    // Cuántas unidades de este producto+talle ya están en el carrito
    private function cantidadEnCarrito(int $productoId, string $talle): int
    {
        if (Auth::check()) {
            return CarritoItem::where('user_id', Auth::id())
                              ->where('producto_id', $productoId)
                              ->where('talle', $talle)
                              ->value('cantidad') ?? 0;
        }
        $carrito = session('carrito', []);
        return $carrito[$productoId . '_' . $talle]['cantidad'] ?? 0;
    }

    // Stock disponible de un producto para un talle específico
    // Busca primero en product_talles, si no existe usa stock general
    private function stockDisponible(Product $producto, string $talle): int
    {
        $talleDB = ProductTalle::where('product_id', $producto->id)
                               ->where('talle', $talle)
                               ->first();

        if ($talleDB) {
            return $talleDB->stock;
        }

        // Si no tiene talles configurados, usar stock general
        return $producto->stock;
    }

    // ── ACCIONES ──────────────────────────────────────────────

    public function index()
    {
        $carrito  = $this->cargarCarrito();
        $subtotal = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);
        return view('Carrito', compact('carrito', 'subtotal'));
    }

    public function agregar(Request $request, $id)
    {
        $producto = Product::with('images')->findOrFail($id);
        $cantidad = max(1, (int) $request->cantidad);
        $talle    = $request->talle ?? 'Único';

        // ── VERIFICACIÓN DE STOCK POR TALLE ───────────────────
        $stockDelTalle   = $this->stockDisponible($producto, $talle);
        $yaEnCarrito     = $this->cantidadEnCarrito((int) $id, $talle);
        $totalSolicitado = $yaEnCarrito + $cantidad;

        if ($stockDelTalle <= 0) {
            return response()->json([
                'ok'    => false,
                'error' => "El stock disponible para el talle {$talle} es de 0 unidades.",
            ], 422);
        }

        if ($totalSolicitado > $stockDelTalle) {
            $disponible = $stockDelTalle - $yaEnCarrito;
            if ($disponible <= 0) {
                return response()->json([
                    'ok'    => false,
                    'error' => "Ya tenés las {$stockDelTalle} unidades disponibles del talle {$talle} en tu carrito.",
                ], 422);
            }
            return response()->json([
                'ok'    => false,
                'error' => "El stock disponible es de {$stockDelTalle} unidades en talle {$talle}. Ya tenés {$yaEnCarrito} en tu carrito, solo podés agregar {$disponible} más.",
            ], 422);
        }
        // ──────────────────────────────────────────────────────

        $item = [
            'producto_id' => (int) $id,
            'nombre'      => $producto->name,
            'precio'      => (float) ($producto->sale_price ?? $producto->price),
            'cantidad'    => $cantidad,
            'talle'       => $talle,
            'imagen'      => $producto->images->where('is_main', true)->first()?->url ?? '',
            'sku'         => $producto->sku ?? '',
        ];

        if (Auth::check()) {
            $this->guardarEnDB($item);
            $total = CarritoItem::where('user_id', Auth::id())->count();
        } else {
            $carrito = session('carrito', []);
            $key     = $id . '_' . $talle;
            if (isset($carrito[$key])) {
                $carrito[$key]['cantidad'] += $cantidad;
            } else {
                $carrito[$key] = $item;
            }
            session(['carrito' => $carrito]);
            $total = count($carrito);
        }

        return response()->json([
            'ok'       => true,
            'mensaje'  => 'Producto agregado.',
            'cantidad' => $total,
        ]);
    }

    public function actualizar(Request $request, $key)
    {
        if (Auth::check()) {
            [$productoId, $talle] = array_pad(explode('_', $key, 2), 2, 'Único');

            $item = CarritoItem::where('user_id', Auth::id())
                               ->where('producto_id', $productoId)
                               ->where('talle', $talle)
                               ->first();

            if ($item) {
                if ($request->accion === 'sumar') {
                    $producto = Product::find($productoId);
                    $stockMax = $this->stockDisponible($producto, $talle);
                    if ($item->cantidad < $stockMax) {
                        $item->increment('cantidad');
                    }
                } elseif ($request->accion === 'restar' && $item->cantidad > 1) {
                    $item->decrement('cantidad');
                }
            }
        } else {
            $carrito = session('carrito', []);
            if (isset($carrito[$key])) {
                if ($request->accion === 'sumar') {
                    [$productoId, $talle] = array_pad(explode('_', $key, 2), 2, 'Único');
                    $producto = Product::find($productoId);
                    $stockMax = $this->stockDisponible($producto, $talle);
                    if ($carrito[$key]['cantidad'] < $stockMax) {
                        $carrito[$key]['cantidad']++;
                    }
                } elseif ($request->accion === 'restar' && $carrito[$key]['cantidad'] > 1) {
                    $carrito[$key]['cantidad']--;
                }
                session(['carrito' => $carrito]);
            }
        }

        return back();
    }

    public function eliminar($key)
    {
        if (Auth::check()) {
            [$productoId, $talle] = array_pad(explode('_', $key, 2), 2, 'Único');
            CarritoItem::where('user_id', Auth::id())
                       ->where('producto_id', $productoId)
                       ->where('talle', $talle)
                       ->delete();
        } else {
            $carrito = session('carrito', []);
            unset($carrito[$key]);
            session(['carrito' => $carrito]);
        }

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        if (Auth::check()) {
            CarritoItem::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('carrito');
        }

        return back()->with('success', 'Carrito vaciado.');
    }
}