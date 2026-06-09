<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, Factura};
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');
        if ($request->estado)  $query->where('status', $request->estado);
        if ($request->search) {
            $query->whereHas('user', fn($q) =>
                $q->where('name', 'like', '%'.$request->search.'%')
            )->orWhere('id', $request->search);
        }
        $ventas = $query->latest()->paginate(20)->withQueryString();
        return view('admin.ventas.index', compact('ventas'));
    }

    public function show(Order $venta)
    {
        $venta->load('user', 'address', 'items.product', 'payment', 'factura');
        return view('admin.ventas.show', compact('venta'));
    }

    public function cambiarEstado(Request $request, Order $venta)
    {
        $request->validate(['status' => 'required|in:pendiente,confirmado,preparando,enviado,entregado,cancelado']);
        $venta->update(['status' => $request->status]);

        // Si se confirma el pedido, generar factura automáticamente
        if ($request->status === 'confirmado' && ! $venta->factura) {
            Factura::create([
                'numero'    => Factura::generarNumero(),
                'order_id'  => $venta->id,
                'user_id'   => $venta->user_id,
                'subtotal'  => $venta->subtotal,
                'impuestos' => 0,
                'total'     => $venta->total,
                'estado'    => 'emitida',
            ]);
        }

        return back()->with('success', 'Estado actualizado a: '.$request->status);
    }
}