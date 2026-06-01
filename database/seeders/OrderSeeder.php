<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $clientes  = User::where('role', 'cliente')->get();
        $productos = Product::where('is_active', true)->get();

        $statuses = ['pendiente', 'confirmado', 'preparando', 'enviado', 'entregado', 'cancelado'];
        $metodos  = ['tarjeta_credito', 'tarjeta_debito', 'transferencia', 'mercadopago'];

        foreach ($clientes as $cliente) {
            $cantOrdenes = rand(1, 4);

            for ($i = 0; $i < $cantOrdenes; $i++) {
                $address = Address::where('user_id', $cliente->id)->first();
                if (! $address) continue;

                $status   = fake()->randomElement($statuses);
                $items    = $productos->random(rand(1, 4));
                $subtotal = 0;

                $order = Order::create([
                    'user_id'       => $cliente->id,
                    'address_id'    => $address->id,
                    'status'        => $status,
                    'subtotal'      => 0,  // se actualiza abajo
                    'shipping_cost' => fake()->randomElement([0, 500, 1000, 1500]),
                    'discount'      => 0,
                    'total'         => 0,
                    'created_at'    => fake()->dateTimeBetween('-6 months', 'now'),
                ]);

                foreach ($items as $producto) {
                    $qty      = rand(1, 3);
                    $precio   = $producto->sale_price ?? $producto->price;
                    $itemSub  = $precio * $qty;
                    $subtotal += $itemSub;

                    OrderItem::create([
                        'order_id'     => $order->id,
                        'product_id'   => $producto->id,
                        'product_name' => $producto->name,
                        'unit_price'   => $precio,
                        'quantity'     => $qty,
                        'subtotal'     => $itemSub,
                    ]);
                }

                $total = $subtotal + $order->shipping_cost;
                $order->update(['subtotal' => $subtotal, 'total' => $total]);

                // Crear pago (solo si no está pendiente ni cancelado)
                $pagoStatus = match($status) {
                    'entregado', 'enviado', 'preparando', 'confirmado' => 'aprobado',
                    'cancelado'  => 'rechazado',
                    default      => 'pendiente',
                };

                Payment::create([
                    'order_id'       => $order->id,
                    'method'         => fake()->randomElement($metodos),
                    'status'         => $pagoStatus,
                    'amount'         => $total,
                    'transaction_id' => $pagoStatus === 'aprobado'
                                        ? strtoupper(fake()->bothify('TXN-########'))
                                        : null,
                    'paid_at'        => $pagoStatus === 'aprobado' ? $order->created_at : null,
                ]);
            }
        }

        $this->command->info('✓ Órdenes, items y pagos creados.');
    }
}
