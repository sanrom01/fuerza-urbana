<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'name' => 'Electrónica',
                'sub'  => ['Celulares', 'Computadoras', 'Tablets', 'Accesorios'],
            ],
            [
                'name' => 'Ropa',
                'sub'  => ['Hombre', 'Mujer', 'Niños'],
            ],
            [
                'name' => 'Hogar',
                'sub'  => ['Muebles', 'Decoración', 'Cocina'],
            ],
            [
                'name' => 'Deportes',
                'sub'  => ['Fútbol', 'Gym', 'Running'],
            ],
        ];

        foreach ($categorias as $orden => $data) {
            $padre = Category::create([
                'name'        => $data['name'],
                'slug'        => Str::slug($data['name']),
                'description' => 'Categoría: ' . $data['name'],
                'parent_id'   => null,
                'is_active'   => true,
                'sort_order'  => $orden,
            ]);

            foreach ($data['sub'] as $subOrden => $sub) {
                Category::create([
                    'name'        => $sub,
                    'slug'        => Str::slug($data['name'] . '-' . $sub),
                    'description' => $sub . ' en ' . $data['name'],
                    'parent_id'   => $padre->id,
                    'is_active'   => true,
                    'sort_order'  => $subOrden,
                ]);
            }
        }

        $this->command->info('✓ Categorías y subcategorías creadas.');
    }
}
