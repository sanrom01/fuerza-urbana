<?php
// ── CategoriaController ────────────────────────────────────────────────────

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Category::withTrashed()->withCount('products')->latest()->paginate(15);
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $data['slug']      = Str::slug($data['name']).'-'.uniqid();
        $data['is_active'] = $request->boolean('is_active');
        Category::create($data);
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada.');
    }

    public function edit(Category $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Category $categoria)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,'.$categoria->id,
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $categoria->update($data);
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Category $categoria)
    {
        $categoria->delete();
        return back()->with('success', 'Categoría eliminada (baja lógica).');
    }

    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Categoría restaurada.');
    }
}