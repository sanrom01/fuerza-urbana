<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        $provincias = ['Corrientes', 'Chaco', 'Misiones', 'Buenos Aires', 'Santa Fe', 'Córdoba'];

        return [
            'street'      => fake()->streetAddress(),
            'city'        => fake()->city(),
            'province'    => fake()->randomElement($provincias),
            'postal_code' => fake()->numerify('####'),
            'country'     => 'Argentina',
            'notes'       => fake()->boolean(30) ? 'Piso ' . rand(1,10) . ', Depto ' . rand(1,20) : null,
            'is_default'  => true,
        ];
    }
}
