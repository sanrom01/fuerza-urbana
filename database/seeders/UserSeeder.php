<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin fijo con credenciales conocidas para desarrollo
        $admin = User::factory()->admin()->create([
            'name'  => 'Administrador',
            'email' => 'admin@tienda.com',
        ]);

        Address::create([
            'user_id'     => $admin->id,
            'street'      => 'Av. Independencia 1234',
            'city'        => 'Corrientes',
            'province'    => 'Corrientes',
            'postal_code' => 'W3400',
            'country'     => 'Argentina',
            'is_default'  => true,
        ]);

        // Cliente fijo para probar el flujo de compra
        $cliente = User::factory()->create([
            'name'  => 'Cliente Prueba',
            'email' => 'cliente@tienda.com',
        ]);

        Address::create([
            'user_id'     => $cliente->id,
            'street'      => 'San Juan 567',
            'city'        => 'Corrientes',
            'province'    => 'Corrientes',
            'postal_code' => 'W3400',
            'country'     => 'Argentina',
            'is_default'  => true,
        ]);

        // 10 clientes aleatorios, cada uno con 1 o 2 direcciones
        User::factory(10)->create()->each(function ($user) {
            Address::factory(rand(1, 2))->create([
                'user_id'    => $user->id,
                'is_default' => true,
            ]);
        });

        $this->command->info('✓ Usuarios y direcciones creados.');
    }
}
