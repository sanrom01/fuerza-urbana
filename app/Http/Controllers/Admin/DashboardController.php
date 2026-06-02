<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Product, Order, Consulta};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'productos'        => Product::whereNull('deleted_at')->count(),
            'usuarios'         => User::where('role', 'cliente')->whereNull('deleted_at')->count(),
            'ventas'           => Order::where('status', '!=', 'cancelado')->count(),
            'consultas'        => Consulta::where('estado', 'pendiente')->count(),
            'facturacion_mes'  => Order::whereMonth('created_at', now()->month)
                                       ->where('status', '!=', 'cancelado')
                                       ->sum('total'),
            'sin_stock'        => Product::where('stock', 0)->whereNull('deleted_at')->count(),
        ];

        // Ventas de los últimos 6 meses para el gráfico
        $ventasMes = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mes"),
                DB::raw('COUNT(*) as cantidad'),
                DB::raw('SUM(total) as monto')
            )
            ->where('status', '!=', 'cancelado')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Últimas 5 ventas
        $ultimasVentas = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Productos con stock bajo
        $stockBajo = Product::with('category')
            ->whereColumn('stock', '<=', 'stock_min')
            ->whereNull('deleted_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ventasMes', 'ultimasVentas', 'stockBajo'));
    }
}