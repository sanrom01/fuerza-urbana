<?php

namespace App\Http\Controllers;

use App\Models\{Order, OrderItem, Payment, Address, Factura, Product, ProductTalle};
use App\Models\CarritoItem;
use App\Mail\ComprobantePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $carrito = $this->obtenerCarrito();

        if (empty($carrito)) {
            return redirect()->route('carrito.index')
                             ->with('error', 'Tu carrito está vacío.');
        }

        $subtotal    = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);
        $direcciones = Auth::user()->addresses;

        return view('checkout.index', compact('carrito', 'subtotal', 'direcciones'));
    }

    public function procesar(Request $request)
    {
        $carrito = $this->obtenerCarrito();

        if (empty($carrito)) {
            return redirect()->route('carrito.index');
        }

        $request->validate([
            'calle'         => 'required|string|max:255',
            'ciudad'        => 'required|string|max:100',
            'provincia'     => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'tipo_tarjeta'  => 'required|in:visa,mastercard,amex,debito',
            'num_tarjeta'   => 'required|digits:16',
            'vencimiento'   => 'required|string|size:5',
            'titular'       => 'required|string|max:100',
            'cvv'           => 'required|digits_between:3,4',
        ], [
            'calle.required'         => 'La calle es obligatoria.',
            'ciudad.required'        => 'La ciudad es obligatoria.',
            'provincia.required'     => 'La provincia es obligatoria.',
            'codigo_postal.required' => 'El código postal es obligatorio.',
            'tipo_tarjeta.required'  => 'Seleccioná el tipo de tarjeta.',
            'num_tarjeta.required'   => 'El número de tarjeta es obligatorio.',
            'num_tarjeta.digits'     => 'El número debe tener 16 dígitos.',
            'vencimiento.required'   => 'La fecha de vencimiento es obligatoria.',
            'titular.required'       => 'El nombre del titular es obligatorio.',
            'cvv.required'           => 'El código de seguridad es obligatorio.',
        ]);

        // ── VERIFICACIÓN DE STOCK ──────────────────────────────
        // Se hace DENTRO de una transacción con bloqueo (FOR UPDATE)
        // para evitar que dos compras simultáneas pasen al mismo tiempo
        DB::beginTransaction();

        try {
            $erroresStock = [];

            foreach ($carrito as $item) {
                $productoId = $item['producto_id'];
                $cantidad   = $item['cantidad'];
                $talle      = $item['talle'] ?? 'Único';

                // lockForUpdate() bloquea la fila hasta que termine la transacción
                $producto = Product::lockForUpdate()->find($productoId);

                if (!$producto) {
                    $erroresStock[] = "El producto \"{$item['nombre']}\" ya no está disponible.";
                    continue;
                }

                if (!$producto->is_active) {
                    $erroresStock[] = "El producto \"{$producto->name}\" ya no está disponible.";
                    continue;
                }

                // Verificar stock del talle específico
                $talleDB = ProductTalle::where('product_id', $productoId)
                                       ->where('talle', $talle)
                                       ->lockForUpdate()
                                       ->first();

                // Si tiene talles configurados usar stock por talle, sino usar stock general
                $stockDisponible = $talleDB ? $talleDB->stock : $producto->stock;

                if ($stockDisponible < $cantidad) {
                    if ($stockDisponible === 0) {
                        $erroresStock[] = "El talle {$talle} de \"{$producto->name}\" se quedó sin stock.";
                    } else {
                        $erroresStock[] = "Solo quedan {$stockDisponible} unidades de \"{$producto->name}\" en talle {$talle} (solicitaste {$cantidad}).";
                    }
                }
            }

            // Si hay errores de stock, cancelar y mostrarlos al usuario
            if (!empty($erroresStock)) {
                DB::rollBack();
                return back()
                    ->with('error_stock', $erroresStock)
                    ->withInput();
            }

            // ── TODO OK — PROCESAR LA COMPRA ──────────────────

            // 1. Guardar dirección
            $address = Address::create([
                'user_id'     => Auth::id(),
                'street'      => $request->calle,
                'city'        => $request->ciudad,
                'province'    => $request->provincia,
                'postal_code' => $request->codigo_postal,
                'country'     => 'Argentina',
                'is_default'  => false,
            ]);

            // 2. Calcular totales
            $subtotal = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);
            $envio    = 1000;
            $total    = $subtotal + $envio;

            // 3. Crear orden
            $order = Order::create([
                'user_id'       => Auth::id(),
                'address_id'    => $address->id,
                'status'        => 'confirmado',
                'subtotal'      => $subtotal,
                'shipping_cost' => $envio,
                'discount'      => 0,
                'total'         => $total,
            ]);

            // 4. Crear items Y descontar stock
            foreach ($carrito as $item) {
                $productoId     = $item['producto_id'];
                $talle          = $item['talle'] ?? 'Único';
                $nombreCompleto = $item['nombre'] . ' (Talle ' . $talle . ')';

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $productoId,
                    'product_name' => $nombreCompleto,
                    'unit_price'   => $item['precio'],
                    'quantity'     => $item['cantidad'],
                    'subtotal'     => $item['precio'] * $item['cantidad'],
                ]);

                // Descontar stock general del producto
                Product::where('id', $productoId)
                       ->decrement('stock', $item['cantidad']);

                // Descontar stock del talle específico si existe
                ProductTalle::where('product_id', $productoId)
                            ->where('talle', $talle)
                            ->decrement('stock', $item['cantidad']);
            }

            // 5. Registrar pago
            $metodo = in_array($request->tipo_tarjeta, ['visa', 'mastercard', 'amex'])
                      ? 'tarjeta_credito' : 'tarjeta_debito';

            Payment::create([
                'order_id'       => $order->id,
                'method'         => $metodo,
                'status'         => 'aprobado',
                'amount'         => $total,
                'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                'paid_at'        => now(),
            ]);

            // 6. Generar factura
            $factura = Factura::create([
                'numero'    => Factura::generarNumero(),
                'order_id'  => $order->id,
                'user_id'   => Auth::id(),
                'subtotal'  => $subtotal,
                'impuestos' => 0,
                'total'     => $total,
                'estado'    => 'emitida',
            ]);

            // 7. Limpiar carrito (BD y sesión)
            CarritoItem::where('user_id', Auth::id())->delete();
            session()->forget('carrito');

            DB::commit();

            // 8. Enviar email
            try {
                Mail::to(Auth::user()->email)
                    ->send(new ComprobantePedido(
                        $order->load('items', 'payment', 'address'),
                        $factura
                    ));
            } catch (\Exception $e) {
                Log::error('Error enviando comprobante: ' . $e->getMessage());
            }

            return redirect()->route('checkout.comprobante', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en checkout: ' . $e->getMessage());
            return back()
                ->with('error', 'Hubo un error al procesar tu compra. Por favor intentá de nuevo.')
                ->withInput();
        }
    }

    public function comprobante($orderId)
    {
        $order = Order::with('items.product', 'payment', 'address', 'factura')
                      ->where('user_id', Auth::id())
                      ->findOrFail($orderId);

        return view('checkout.comprobante', compact('order'));
    }

    // Obtiene el carrito desde BD (logueado) o sesión (invitado)
    private function obtenerCarrito(): array
    {
        if (Auth::check()) {
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

        return session('carrito', []);
    }
}