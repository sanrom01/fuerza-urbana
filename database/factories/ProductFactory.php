<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::inRandomOrder()->first()?->id
                             ?? Category::factory(),
            'name'        => ucfirst($name),
            'slug'        => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->paragraph(3),
            'sku'         => strtoupper(fake()->unique()->bothify('SKU-####-??')),
            'price'       => fake()->randomElement([999, 1499, 2999, 4999, 7999, 12999, 24999]),
            'sale_price'  => fake()->boolean(30)  // 30% de chance de tener descuento
                             ? fake()->randomElement([799, 1199, 2499, 3999])
                             : null,
            'stock'       => fake()->numberBetween(0, 100),
            'stock_min'   => 5,
            'is_active'   => fake()->boolean(85), // 85% activos
            'featured'    => fake()->boolean(20), // 20% destacados
        ];
    }

    public function featured(): static
    {
        return $this->state(['featured' => true, 'is_active' => true]);
    }

    public function sinStock(): static
    {
        return $this->state(['stock' => 0]);
    }
}
