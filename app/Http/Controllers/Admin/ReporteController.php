<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, Product, User, OrderItem};
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        // Ventas por mes (últimos 12 meses)
        $ventasPorMes = Order::select(
                DB::raw("DATE_FORMAT(created_at,'%Y-%m') as mes"),
                DB::raw('COUNT(*) as ordenes'),
                DB::raw('SUM(total) as monto')
            )
            ->where('status', '!=', 'cancelado')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('mes')->orderBy('mes')->get();

        // Productos más vendidos (top 10)
        $masVendidos = OrderItem::select('product_id',
                DB::raw('SUM(quantity) as unidades'),
                DB::raw('SUM(subtotal) as facturado')
            )
            ->with('product')
            ->whereHas('order', fn($q) => $q->where('status', '!=', 'cancelado'))
            ->groupBy('product_id')
            ->orderByDesc('unidades')
            ->take(10)->get();

        // Clientes con más compras (top 10)
        $mejoresClientes = Order::select('user_id',
                DB::raw('COUNT(*) as ordenes'),
                DB::raw('SUM(total) as total_gastado')
            )
            ->with('user')
            ->where('status', '!=', 'cancelado')
            ->groupBy('user_id')
            ->orderByDesc('total_gastado')
            ->take(10)->get();

        // Productos sin stock
        $sinStock = Product::with('category')
            ->where('stock', 0)
            ->whereNull('deleted_at')
            ->get();

        return view('admin.reportes.index', compact(
            'ventasPorMes', 'masVendidos', 'mejoresClientes', 'sinStock'
        ));
    }
}