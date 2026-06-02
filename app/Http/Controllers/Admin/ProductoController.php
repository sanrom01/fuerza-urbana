<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->withTrashed();

        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        if ($request->categoria) {
            $query->where('category_id', $request->categoria);
        }
        if ($request->estado === 'eliminado') {
            $query->whereNotNull('deleted_at');
        } elseif ($request->estado === 'inactivo') {
            $query->whereNull('deleted_at')->where('is_active', false);
        } else {
            $query->whereNull('deleted_at');
        }

        $productos   = $query->latest()->paginate(15)->withQueryString();
        $categorias  = Category::where('is_active', true)->get();

        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Category::where('is_active', true)->get();
        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'sku'         => 'nullable|string|unique:products,sku',
            'is_active'   => 'boolean',
            'featured'    => 'boolean',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        $data['slug']      = Str::slug($data['name']).'-'.uniqid();
        $data['is_active'] = $request->boolean('is_active');
        $data['featured']  = $request->boolean('featured');
        $data['stock_min'] = 5;

        $producto = Product::create($data);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->images()->create([
                'url'      => '/storage/'.$path,
                'alt_text' => $producto->name,
                'is_main'  => true,
            ]);
        }

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto creado correctamente.');
    }

    public function show(Product $producto)
    {
        $producto->load('category', 'images', 'reviews.user');
        return view('admin.productos.show', compact('producto'));
    }

    public function edit(Product $producto)
    {
        $categorias = Category::where('is_active', true)->get();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Product $producto)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'sku'         => 'nullable|string|unique:products,sku,'.$producto->id,
            'is_active'   => 'boolean',
            'featured'    => 'boolean',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['featured']  = $request->boolean('featured');

        $producto->update($data);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->images()->where('is_main', true)->update(['is_main' => false]);
            $producto->images()->create([
                'url'      => '/storage/'.$path,
                'alt_text' => $producto->name,
                'is_main'  => true,
            ]);
        }

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $producto)
    {
        $producto->delete(); // SoftDelete
        return back()->with('success', 'Producto eliminado (baja lógica).');
    }

    public function restore($id)
    {
        Product::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Producto restaurado.');
    }
}