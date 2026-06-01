<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Productos reales por categoría para datos más representativos
        $productos = [
            'Celulares'    => ['Samsung Galaxy A55', 'Motorola Edge 50', 'iPhone 14', 'Xiaomi Redmi Note 13'],
            'Computadoras' => ['Notebook Lenovo IdeaPad', 'PC Gamer AMD Ryzen', 'MacBook Air M2'],
            'Tablets'      => ['iPad 10ma Gen', 'Samsung Tab A9', 'Lenovo Tab M10'],
            'Fútbol'       => ['Pelota Adidas Copa', 'Botines Nike Tiempo', 'Arco plegable'],
            'Gym'          => ['Mancuernas 10kg', 'Colchoneta yoga', 'Banda elástica set'],
            'Muebles'      => ['Silla ergonómica', 'Mesa de trabajo', 'Estantería metálica'],
            'Cocina'       => ['Licuadora Oster', 'Sartén antiadherente', 'Juego de cuchillos'],
        ];

        foreach ($productos as $categoriaNombre => $items) {
            $categoria = Category::where('name', $categoriaNombre)->first();
            if (! $categoria) continue;

            foreach ($items as $nombre) {
                $precio = fake()->randomElement([4999, 9999, 14999, 24999, 49999, 99999]);

                $product = Product::create([
                    'category_id' => $categoria->id,
                    'name'        => $nombre,
                    'slug'        => Str::slug($nombre) . '-' . fake()->unique()->numberBetween(1, 999),
                    'description' => fake()->paragraph(2),
                    'sku'         => strtoupper(Str::random(3) . '-' . fake()->unique()->numberBetween(1000, 9999)),
                    'price'       => $precio,
                    'sale_price'  => fake()->boolean(25) ? $precio * 0.8 : null,
                    'stock'       => fake()->numberBetween(5, 50),
                    'stock_min'   => 5,
                    'is_active'   => true,
                    'featured'    => fake()->boolean(20),
                ]);

                // Imagen placeholder para cada producto
                ProductImage::create([
                    'product_id' => $product->id,
                    'url'        => 'https://picsum.photos/seed/' . $product->id . '/600/600',
                    'alt_text'   => $nombre,
                    'is_main'    => true,
                    'sort_order' => 0,
                ]);
            }
        }

        // Además genera 20 productos aleatorios con factory
        Product::factory(20)->create()->each(function ($product) {
            ProductImage::create([
                'product_id' => $product->id,
                'url'        => 'https://picsum.photos/seed/' . $product->id . '/600/600',
                'alt_text'   => $product->name,
                'is_main'    => true,
                'sort_order' => 0,
            ]);
        });

        $this->command->info('✓ Productos e imágenes creados.');
    }
}
