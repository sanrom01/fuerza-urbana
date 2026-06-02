<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withTrashed();
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->rol) $query->where('role', $request->rol);

        $usuarios = $query->latest()->paginate(20)->withQueryString();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function show(User $usuario)
    {
        $usuario->load('orders.payment', 'addresses');
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$usuario->id,
            'phone' => 'nullable|string|max:20',
            'role'  => 'required|in:admin,cliente',
        ]);
        $usuario->update($data);
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado.');
    }

    public function desactivar(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No podés desactivar tu propia cuenta.');
        }
        $usuario->delete(); // SoftDelete
        return back()->with('success', 'Usuario desactivado.');
    }

    public function restore($id)
    {
        User::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Usuario restaurado.');
    }
}