<?php

namespace App\Http\Controllers;

use App\Models\{Order, OrderItem, Payment, Address, Factura};
use App\Mail\ComprobantePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Mail, DB};

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar formulario de checkout
    public function index()
    {
        $carrito = session('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.index')
                             ->with('error', 'Tu carrito está vacío.');
        }

        $subtotal   = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);
        $direcciones = Auth::user()->addresses;

        return view('checkout.index', compact('carrito', 'subtotal', 'direcciones'));
    }

    // Procesar la compra
    public function procesar(Request $request)
    {
        $carrito = session('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.index');
        }

        $request->validate([
            // Envío
            'calle'        => 'required|string|max:255',
            'ciudad'       => 'required|string|max:100',
            'provincia'    => 'required|string|max:100',
            'codigo_postal'=> 'required|string|max:10',
            // Pago
            'tipo_tarjeta' => 'required|in:visa,mastercard,amex,debito',
            'num_tarjeta'  => 'required|digits:16',
            'vencimiento'  => 'required|string|size:5',
            'titular'      => 'required|string|max:100',
            'cvv'          => 'required|digits_between:3,4',
        ], [
            'calle.required'         => 'La calle es obligatoria.',
            'ciudad.required'        => 'La ciudad es obligatoria.',
            'provincia.required'     => 'La provincia es obligatoria.',
            'codigo_postal.required' => 'El código postal es obligatorio.',
            'tipo_tarjeta.required'  => 'Seleccioná el tipo de tarjeta.',
            'num_tarjeta.required'   => 'El número de tarjeta es obligatorio.',
            'num_tarjeta.digits'     => 'El número de tarjeta debe tener 16 dígitos.',
            'vencimiento.required'   => 'La fecha de vencimiento es obligatoria.',
            'titular.required'       => 'El nombre del titular es obligatorio.',
            'cvv.required'           => 'El código de seguridad es obligatorio.',
        ]);

        DB::beginTransaction();
        try {
            // 1. Guardar dirección si es nueva
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
            $subtotal     = collect($carrito)->sum(fn($i) => $i['precio'] * $i['cantidad']);
            $envio        = 1000; // Costo fijo de envío
            $total        = $subtotal + $envio;

            // 3. Crear la orden
            $order = Order::create([
                'user_id'      => Auth::id(),
                'address_id'   => $address->id,
                'status'       => 'confirmado',
                'subtotal'     => $subtotal,
                'shipping_cost'=> $envio,
                'discount'     => 0,
                'total'        => $total,
            ]);

            // 4. Crear items de la orden
            foreach ($carrito as $id => $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $id,
                    'product_name' => $item['nombre'],
                    'unit_price'   => $item['precio'],
                    'quantity'     => $item['cantidad'],
                    'subtotal'     => $item['precio'] * $item['cantidad'],
                ]);
            }

            // 5. Registrar el pago
            $metodo = in_array($request->tipo_tarjeta, ['visa','mastercard','amex'])
                      ? 'tarjeta_credito' : 'tarjeta_debito';

            Payment::create([
                'order_id'       => $order->id,
                'method'         => $metodo,
                'status'         => 'aprobado',
                'amount'         => $total,
                'transaction_id' => 'TXN-'.strtoupper(uniqid()),
                'paid_at'        => now(),
            ]);

            // 6. Generar factura
            $factura = Factura::create([
                'numero'   => Factura::generarNumero(),
                'order_id' => $order->id,
                'user_id'  => Auth::id(),
                'subtotal' => $subtotal,
                'impuestos'=> 0,
                'total'    => $total,
                'estado'   => 'emitida',
            ]);

            // 7. Limpiar carrito
            session()->forget('carrito');

            DB::commit();

            // 8. Enviar email con comprobante
            try {
                Mail::to(Auth::user()->email)
                    ->send(new ComprobantePedido($order->load('items', 'payment', 'address'), $factura));
            } catch (\Exception $e) {
                // Si falla el email no rompemos el proceso
                \Log::error('Error enviando comprobante: '.$e->getMessage());
            }

            // 9. Mostrar comprobante
            return redirect()->route('checkout.comprobante', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Hubo un error al procesar tu compra. Intentá de nuevo.')
                         ->withInput();
        }
    }

    // Mostrar comprobante
    public function comprobante($orderId)
    {
        $order = Order::with('items.product', 'payment', 'address', 'factura')
                      ->where('user_id', Auth::id())
                      ->findOrFail($orderId);

        return view('checkout.comprobante', compact('order'));
    }
}
