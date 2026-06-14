<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductoPublicoController extends Controller
{
    // Catálogo — lee productos reales de la base de datos
    public function index(Request $request)
    {
        $query = Product::with('category', 'images')
                        ->where('is_active', true)
                        ->whereNull('deleted_at');

        // Filtro por categoría (slug)
        if ($request->filled('categoria')) {
            $query->whereHas('category', fn($q) =>
                $q->where('slug', $request->categoria)
            );
        }

        // Filtro por búsqueda
        if ($request->filled('buscar')) {
            $query->where('name', 'like', '%' . $request->buscar . '%');
        }

        // Filtro por precio máximo
        if ($request->filled('precio_max')) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '<=', $request->precio_max)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')
                         ->where('price', '<=', $request->precio_max);
                  });
            });
        }

        // Ordenamiento
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

    // Detalle de producto
    public function show($slug)
    {
        $producto = Product::with('category', 'images', 'reviews.user')
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

        return view('shop.producto', compact('producto', 'relacionados'));
    }
}