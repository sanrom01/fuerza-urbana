<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $query = Consulta::with('user');

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        // Búsqueda por nombre o email
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('mensaje', 'like', '%'.$request->search.'%');
            });
        }

        $consultas = $query->latest()->paginate(20)->withQueryString();

        return view('admin.consultas.index', compact('consultas'));
    }

    public function show(Consulta $consulta)
    {
        return view('admin.consultas.show', compact('consulta'));
    }

    public function responder(Request $request, Consulta $consulta)
    {
        $request->validate([
            'respuesta' => 'required|string|min:5',
        ], [
            'respuesta.required' => 'La respuesta es obligatoria.',
            'respuesta.min'      => 'La respuesta debe tener al menos 5 caracteres.',
        ]);

        $consulta->update([
            'estado'        => 'respondida',
            'respuesta'     => $request->respuesta,
            'respondida_at' => now(),
        ]);

        // Enviar email de respuesta al cliente
        try {
            Mail::raw(
                "Hola {$consulta->nombre},\n\n" .
                "Gracias por contactarnos. Te respondemos a continuación:\n\n" .
                "---\nTu mensaje:\n{$consulta->mensaje}\n---\n\n" .
                "Nuestra respuesta:\n{$request->respuesta}\n\n" .
                "Saludos,\nFuerza Urbana",
                function ($mail) use ($consulta) {
                    $mail->to($consulta->email)
                         ->subject('Respuesta a tu consulta — Fuerza Urbana');
                }
            );
            return back()->with('success', 'Consulta respondida y email enviado a ' . $consulta->email);
        } catch (\Exception $e) {
            return back()->with('success', 'Consulta marcada como respondida. (El email no pudo enviarse)');
        }
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return redirect()->route('admin.consultas.index')
                         ->with('success', 'Consulta eliminada.');
    }
}