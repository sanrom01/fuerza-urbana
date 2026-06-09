<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── MOSTRAR LOGIN ──────────────────────────────────────
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }
        return view('Login');
    }

    // ── PROCESAR LOGIN ─────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Ingresá un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $credenciales = $request->only('email', 'password');
        $remember     = $request->boolean('remember');

        if (Auth::attempt($credenciales, $remember)) {
            $request->session()->regenerate();
            return $this->redirigirSegunRol();
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'El correo o la contraseña son incorrectos.']);
    }

    // ── MOSTRAR REGISTRO ───────────────────────────────────
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }
        return view('Register');
    }

    // ── PROCESAR REGISTRO ──────────────────────────────────
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El correo es obligatorio.',
            'email.unique'       => 'Ese correo ya está registrado.',
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

        return redirect()->route('Principal')
                         ->with('success', '¡Bienvenido, ' . $user->name . '!');
    }

    // ── LOGOUT ─────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
                         ->with('success', 'Cerraste sesión correctamente.');
    }

    // ── REDIRECCIÓN SEGÚN ROL ──────────────────────────────
    private function redirigirSegunRol()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/Principal');
    }
}