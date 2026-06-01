<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Solo pueden reseñar productos que compraron y cuya orden fue entregada
        $ordenes = Order::with('items.product', 'user')
                        ->where('status', 'entregado')
                        ->get();

        foreach ($ordenes as $orden) {
            foreach ($orden->items as $item) {
                // 60% de chance de dejar reseña
                if (! fake()->boolean(60)) continue;

                // Evitar duplicado (unique user+product)
                $yaReseño = Review::where('user_id', $orden->user_id)
                                  ->where('product_id', $item->product_id)
                                  ->exists();
                if ($yaReseño) continue;

                Review::create([
                    'user_id'     => $orden->user_id,
                    'product_id'  => $item->product_id,
                    'rating'      => fake()->numberBetween(3, 5), // mayormente positivas
                    'title'       => fake()->randomElement([
                        'Excelente producto',
                        'Muy buena calidad',
                        'Llegó rápido',
                        'Cumple lo que promete',
                        'Lo recomiendo',
                    ]),
                    'comment'     => fake()->paragraph(1),
                    'is_approved' => true,
                    'created_at'  => fake()->dateTimeBetween('-3 months', 'now'),
                ]);
            }
        }

        $this->command->info('✓ Reseñas creadas.');
    }
}
