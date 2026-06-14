@extends('layouts.admin')
@section('title', 'Factura '.$factura->numero)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.facturacion.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">Factura {{ $factura->numero }}</h5>
    <span class="badge {{ $factura->estado == 'emitida' ? 'bg-success' : 'bg-danger' }}">
        {{ strtoupper($factura->estado) }}
    </span>
    <a href="{{ route('admin.facturacion.pdf', $factura) }}" class="btn btn-red btn-sm ms-auto">
        <i class="bi bi-file-earmark-pdf me-2"></i>Descargar PDF
    </a>
</div>

{{-- FACTURA VISUAL --}}
<div class="admin-card" style="max-width:800px;margin:0 auto" id="facturaImprimir">

    {{-- HEADER --}}
    <div class="p-4 text-white" style="background:#1a1a2e">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="fw-bold mb-0">FUERZA URBANA</h4>
                <small style="color:rgba(255,255,255,.6)">Indumentaria deportiva — Corrientes, Argentina</small>
            </div>
            <div class="col text-end">
                <div class="fw-bold fs-5 text-danger">{{ $factura->numero }}</div>
                <small style="color:rgba(255,255,255,.6)">{{ $factura->created_at->format('d/m/Y H:i') }}</small>
            </div>
        </div>
    </div>

    <div class="p-4">

        {{-- DATOS --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <h6 class="text-danger fw-600 text-uppercase small mb-2">Cliente</h6>
                <div class="fw-500">{{ $factura->user->name }}</div>
                <div class="text-muted small">{{ $factura->user->email }}</div>
                <div class="text-muted small">{{ $factura->user->phone ?? '' }}</div>
            </div>
            <div class="col-md-6">
                <h6 class="text-danger fw-600 text-uppercase small mb-2">Datos de factura</h6>
                <table class="table table-sm mb-0">
                    <tr><td class="text-muted small ps-0">Número</td><td class="small fw-600">{{ $factura->numero }}</td></tr>
                    <tr><td class="text-muted small ps-0">Pedido</td>
                        <td><a href="{{ route('admin.ventas.show', $factura->order) }}" class="small text-danger">#{{ str_pad($factura->order_id,5,'0',STR_PAD_LEFT) }}</a></td></tr>
                    <tr><td class="text-muted small ps-0">Fecha</td><td class="small">{{ $factura->created_at->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted small ps-0">Estado</td>
                        <td><span class="badge {{ $factura->estado=='emitida'?'bg-success':'bg-danger' }}">{{ $factura->estado }}</span></td></tr>
                </table>
            </div>
        </div>

        <hr>

        {{-- DETALLE DE PRODUCTOS --}}
        <h6 class="fw-600 mb-3">Detalle del pedido</h6>
        <table class="table">
            <thead style="background:#f8f7fd">
                <tr>
                    <th class="small text-uppercase text-muted fw-600">Producto</th>
                    <th class="small text-uppercase text-muted fw-600 text-center">Cant.</th>
                    <th class="small text-uppercase text-muted fw-600 text-end">Precio unit.</th>
                    <th class="small text-uppercase text-muted fw-600 text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factura->order->items as $item)
                <tr>
                    <td class="fw-500">{{ $item->product_name }}</td>
                    <td class="text-center text-muted">{{ $item->quantity }}</td>
                    <td class="text-end">${{ number_format($item->unit_price,0,',','.') }}</td>
                    <td class="text-end fw-500">${{ number_format($item->subtotal,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end text-muted">Subtotal</td>
                    <td class="text-end">${{ number_format($factura->subtotal,0,',','.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-end text-muted">Envío</td>
                    <td class="text-end">${{ number_format($factura->order->shipping_cost,0,',','.') }}</td>
                </tr>
                @if($factura->impuestos > 0)
                <tr>
                    <td colspan="3" class="text-end text-muted">Impuestos</td>
                    <td class="text-end">${{ number_format($factura->impuestos,0,',','.') }}</td>
                </tr>
                @endif
                <tr style="border-top:2px solid #ddd">
                    <td colspan="3" class="text-end fw-700 fs-5">TOTAL</td>
                    <td class="text-end fw-700 fs-5 text-danger">${{ number_format($factura->total,0,',','.') }}</td>
                </tr>
            </tfoot>
        </table>

        {{-- DIRECCIÓN --}}
        @if($factura->order->address)
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-600 small text-uppercase text-danger mb-2">Dirección de envío</h6>
                <div class="text-muted small">
                    {{ $factura->order->address->street }},
                    {{ $factura->order->address->city }},
                    {{ $factura->order->address->province }}
                    (CP {{ $factura->order->address->postal_code }})
                </div>
            </div>
            @if($factura->order->payment)
            <div class="col-md-6">
                <h6 class="fw-600 small text-uppercase text-danger mb-2">Método de pago</h6>
                <div class="text-muted small">
                    {{ $factura->order->payment->method }}
                    @if($factura->order->payment->transaction_id)
                    — TXN: {{ $factura->order->payment->transaction_id }}
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="px-4 py-3 text-center text-muted small" style="background:#f8f7fd;border-top:1px solid #eee">
        Gracias por tu compra en <strong>Fuerza Urbana</strong> — contacto@fuerzaurbana.com
    </div>
</div>

<div class="text-center mt-4">
    <button onclick="window.print()" class="btn btn-outline-secondary">
        <i class="bi bi-printer me-2"></i>Imprimir
    </button>
</div>
@endsection

@push('styles')
<style>
@media print {
    #sidebar, #topbar, .btn, nav { display: none !important; }
    #main { margin-left: 0 !important; padding-top: 0 !important; }
    #facturaImprimir { max-width: 100% !important; box-shadow: none !important; }
}
</style>
@endpush