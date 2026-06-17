<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CarritoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'El email es obligatorio.',
            'email.email'       => 'Ingresá un email válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $request->session()->regenerate();

            // ── RESTAURAR CARRITO ──────────────────────────────
            // Si había items en sesión (agregó sin login), fusionarlos a la BD
            $sesion = session('carrito', []);
            if (!empty($sesion)) {
                foreach ($sesion as $item) {
                    $existente = CarritoItem::where('user_id', Auth::id())
                                           ->where('producto_id', $item['producto_id'])
                                           ->where('talle', $item['talle'])
                                           ->first();
                    if ($existente) {
                        $existente->increment('cantidad', $item['cantidad']);
                    } else {
                        CarritoItem::create([
                            'user_id'     => Auth::id(),
                            'producto_id' => $item['producto_id'],
                            'nombre'      => $item['nombre'],
                            'precio'      => $item['precio'],
                            'cantidad'    => $item['cantidad'],
                            'talle'       => $item['talle'],
                            'imagen'      => $item['imagen'],
                            'sku'         => $item['sku'] ?? '',
                        ]);
                    }
                }
                session()->forget('carrito');
            }
            // ──────────────────────────────────────────────────

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended('/Principal');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('Register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El email es obligatorio.',
            'email.unique'       => 'Ese email ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'cliente',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/Principal');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/Login');
    }
}