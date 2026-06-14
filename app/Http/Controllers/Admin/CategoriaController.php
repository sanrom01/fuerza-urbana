<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    // Listado principal
    public function index()
    {
        $categorias = Category::withTrashed()
                              ->withCount('products')
                              ->with('parent', 'children')
                              ->latest()
                              ->paginate(20);

        return view('admin.categorias.index', compact('categorias'));
    }

    // Formulario crear
    public function create()
    {
        // Solo categorías padre (sin parent_id) para el select de subcategoría
        $padres = Category::whereNull('parent_id')
                          ->whereNull('deleted_at')
                          ->orderBy('name')
                          ->get();

        return view('admin.categorias.create', compact('padres'));
    }

    // Guardar nueva
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer|min:0',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique'   => 'Ya existe una categoría con ese nombre.',
        ]);

        $data['slug']       = Str::slug($data['name']) . '-' . uniqid();
        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['parent_id']  = $request->parent_id ?: null;

        Category::create($data);

        return redirect()->route('admin.categorias.index')
                         ->with('success', 'Categoría creada correctamente.');
    }

    // Formulario editar
    public function edit(Category $categoria)
    {
        $padres = Category::whereNull('parent_id')
                          ->whereNull('deleted_at')
                          ->where('id', '!=', $categoria->id)
                          ->orderBy('name')
                          ->get();

        return view('admin.categorias.edit', compact('categoria', 'padres'));
    }

    // Actualizar
    public function update(Request $request, Category $categoria)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $categoria->id,
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
            'is_active'   => 'boolean',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['parent_id'] = $request->parent_id ?: null;

        $categoria->update($data);

        return redirect()->route('admin.categorias.index')
                         ->with('success', 'Categoría actualizada correctamente.');
    }

    // Baja lógica
    public function destroy(Category $categoria)
    {
        if ($categoria->products()->count() > 0) {
            return back()->with('error', 'No podés eliminar una categoría con productos asignados.');
        }
        $categoria->delete();
        return back()->with('success', 'Categoría eliminada.');
    }

    // Restaurar
    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Categoría restaurada.');
    }
}