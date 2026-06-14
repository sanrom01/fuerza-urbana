<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductoPublicoController extends Controller
{
    // Catálogo
    public function index(Request $request)
    {
        $query = Product::with('category', 'images')
                        ->where('is_active', true)
                        ->whereNull('deleted_at');

        if ($request->categoria) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->categoria));
        }
        if ($request->buscar) {
            $query->where('name', 'like', '%'.$request->buscar.'%');
        }
        if ($request->orden === 'precio_asc')  $query->orderBy('price');
        if ($request->orden === 'precio_desc') $query->orderByDesc('price');
        if ($request->orden === 'nuevo')       $query->latest();

        $productos  = $query->paginate(12)->withQueryString();
        $categorias = Category::where('is_active', true)->whereNull('parent_id')->with('children')->get();

        return view('shop.catalogo', compact('productos', 'categorias'));
    }

    // Detalle de producto
    public function show($slug)
    {
        $producto = Product::with('category', 'images', 'reviews.user')
                           ->where('slug', $slug)
                           ->where('is_active', true)
                           ->firstOrFail();

        // Productos relacionados de la misma categoría
        $relacionados = Product::with('images')
                               ->where('category_id', $producto->category_id)
                               ->where('id', '!=', $producto->id)
                               ->where('is_active', true)
                               ->take(4)->get();

        return view('shop.producto', compact('producto', 'relacionados'));
    }
}
