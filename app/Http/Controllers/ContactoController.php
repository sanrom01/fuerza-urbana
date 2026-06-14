<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        // Validación diferente según si está logueado o no
        if (Auth::check()) {
            $request->validate([
                'mensaje' => 'required|string|min:10|max:2000',
            ], [
                'mensaje.required' => 'El mensaje es obligatorio.',
                'mensaje.min'      => 'El mensaje debe tener al menos 10 caracteres.',
            ]);

            Consulta::create([
                'user_id' => Auth::id(),
                'nombre'  => Auth::user()->name,
                'email'   => Auth::user()->email,
                'asunto'  => 'Consulta de ' . Auth::user()->name,
                'mensaje' => $request->mensaje,
                'estado'  => 'pendiente',
            ]);

        } else {
            $request->validate([
                'nombre'  => 'required|string|max:100',
                'email'   => 'required|email|max:100',
                'mensaje' => 'required|string|min:10|max:2000',
            ], [
                'nombre.required'  => 'El nombre es obligatorio.',
                'email.required'   => 'El correo es obligatorio.',
                'email.email'      => 'Ingresá un correo válido.',
                'mensaje.required' => 'El mensaje es obligatorio.',
                'mensaje.min'      => 'El mensaje debe tener al menos 10 caracteres.',
            ]);

            Consulta::create([
                'user_id' => null,
                'nombre'  => $request->nombre,
                'email'   => $request->email,
                'asunto'  => $request->asunto ?? 'Consulta de ' . $request->nombre,
                'mensaje' => $request->mensaje,
                'estado'  => 'pendiente',
            ]);
        }

        return back()->with('contacto_ok', '¡Mensaje enviado correctamente! Te responderemos a la brevedad.');
    }
}