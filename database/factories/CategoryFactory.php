<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Electrónica', 'Ropa', 'Calzado', 'Hogar', 'Deportes',
            'Juguetes', 'Libros', 'Belleza', 'Alimentos', 'Automotor',
        ]);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => fake()->sentence(),
            'image'       => null,
            'parent_id'   => null,
            'is_active'   => true,
            'sort_order'  => fake()->numberBetween(0, 10),
        ];
    }
}
