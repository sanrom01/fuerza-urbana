<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use Illuminate\Http\Response;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('user', 'order')->latest()->paginate(20);
        return view('admin.facturacion.index', compact('facturas'));
    }

    public function show(Factura $factura)
    {
        $factura->load('user', 'order.items.product', 'order.address');
        return view('admin.facturacion.show', compact('factura'));
    }

    public function descargarPdf(Factura $factura)
    {
        $factura->load('user', 'order.items.product');

        // Requiere: composer require barryvdh/laravel-dompdf
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.facturacion.pdf', compact('factura'));
        return $pdf->download('factura-'.$factura->numero.'.pdf');
    }
}