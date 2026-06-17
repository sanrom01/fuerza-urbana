<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductoPublicoController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'images')
                        ->where('is_active', true)
                        ->whereNull('deleted_at');

        if ($request->filled('categoria')) {
            // Buscar la categoría padre por slug
            $categoriaPadre = Category::where('slug', $request->categoria)
                                      ->whereNull('deleted_at')
                                      ->first();

            if ($categoriaPadre) {
                // Obtener IDs: la categoría padre + todas sus subcategorías
                $ids = Category::where('id', $categoriaPadre->id)
                               ->orWhere('parent_id', $categoriaPadre->id)
                               ->whereNull('deleted_at')
                               ->pluck('id');

                $query->whereIn('category_id', $ids);
            }
        }
        if ($request->filled('buscar')) {
            $query->where('name', 'like', '%' . $request->buscar . '%');
        }
        if ($request->filled('precio_max')) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '<=', $request->precio_max)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')
                         ->where('price', '<=', $request->precio_max);
                  });
            });
        }

        match($request->orden) {
            'precio_asc'  => $query->orderByRaw('COALESCE(sale_price, price) ASC'),
            'precio_desc' => $query->orderByRaw('COALESCE(sale_price, price) DESC'),
            'nuevo'       => $query->latest(),
            default       => $query->orderBy('featured', 'desc')->latest(),
        };

        $productos  = $query->paginate(20)->withQueryString();
        $categorias = Category::where('is_active', true)
                              ->whereNull('parent_id')
                              ->orderBy('sort_order')
                              ->get();

        return view('Catalogos-de-productos', compact('productos', 'categorias'));
    }

    public function show($slug)
    {
        // Cargar talles junto con el producto
        $producto = Product::with('category', 'images', 'reviews.user', 'talles')
                           ->where('slug', $slug)
                           ->where('is_active', true)
                           ->whereNull('deleted_at')
                           ->firstOrFail();

        $relacionados = Product::with('images')
                               ->where('category_id', $producto->category_id)
                               ->where('id', '!=', $producto->id)
                               ->where('is_active', true)
                               ->whereNull('deleted_at')
                               ->take(4)->get();

        return view('Shop.producto', compact('producto', 'relacionados'));
    }
}