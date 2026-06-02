<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Consulta;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $query = Consulta::with('user');
        if ($request->estado) $query->where('estado', $request->estado);
        $consultas = $query->latest()->paginate(20)->withQueryString();
        return view('admin.consultas.index', compact('consultas'));
    }

    public function show(Consulta $consulta)
    {
        return view('admin.consultas.show', compact('consulta'));
    }

    public function responder(Request $request, Consulta $consulta)
    {
        $request->validate(['respuesta' => 'required|string']);
        $consulta->update([
            'estado'         => 'respondida',
            'respuesta'      => $request->respuesta,
            'respondida_at'  => now(),
        ]);
        return back()->with('success', 'Consulta marcada como respondida.');
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return back()->with('success', 'Consulta eliminada.');
    }
}