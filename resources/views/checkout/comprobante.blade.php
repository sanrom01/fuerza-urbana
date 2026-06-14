@extends('layouts.app')
@section('title', 'Comprobante de compra')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- ÉXITO --}}
            <div class="text-center mb-5">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:4rem"></i>
                </div>
                <h2 class="fw-bold text-white">¡Compra realizada con éxito!</h2>
                <p class="text-secondary">Te enviamos el comprobante a <strong class="text-white">{{ Auth::user()->email }}</strong></p>
            </div>

            {{-- COMPROBANTE --}}
            <div class="card bg-dark border-secondary text-white" id="comprobante">
                {{-- ENCABEZADO --}}
                <div class="card-header bg-danger text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-0">FUERZA URBANA</h4>
                            <small>Indumentaria deportiva</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold fs-5">{{ $order->factura->numero ?? 'FAC-00000' }}</div>
                            <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    {{-- DATOS DEL CLIENTE --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h6 class="text-danger text-uppercase small fw-bold mb-2">Cliente</h6>
                            <div class="fw-500">{{ Auth::user()->name }}</div>
                            <div class="text-secondary small">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-danger text-uppercase small fw-bold mb-2">Dirección de envío</h6>
                            <div class="fw-500">{{ $order->address->street }}</div>
                            <div class="text-secondary small">{{ $order->address->city }}, {{ $order->address->province }}</div>
                            <div class="text-secondary small">CP: {{ $order->address->postal_code }}</div>
                        </div>
                    </div>

                    <hr class="border-secondary">

                    {{-- PRODUCTOS --}}
                    <h6 class="text-danger text-uppercase small fw-bold mb-3">Detalle del pedido</h6>
                    <table class="table table-dark table-borderless mb-0">
                        <thead>
                            <tr class="text-secondary small text-uppercase border-bottom border-secondary">
                                <th>Producto</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="fw-500">{{ $item->product_name }}</td>
                                <td class="text-center text-secondary">{{ $item->quantity }}</td>
                                <td class="text-end text-secondary">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="text-end fw-500">${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-top border-secondary">
                                <td colspan="3" class="text-end text-secondary">Subtotal</td>
                                <td class="text-end">${{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-secondary">Envío</td>
                                <td class="text-end">${{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-bold fs-5">TOTAL</td>
                                <td class="text-end fw-bold fs-5 text-danger">${{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <hr class="border-secondary">

                    {{-- PAGO --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-danger text-uppercase small fw-bold mb-2">Pago</h6>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="bi bi-check-circle me-1"></i>APROBADO
                                </span>
                                <span class="text-secondary small">{{ $order->payment->method }}</span>
                            </div>
                            @if($order->payment->transaction_id)
                            <div class="text-secondary small mt-1">
                                TXN: {{ $order->payment->transaction_id }}
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-danger text-uppercase small fw-bold mb-2">Estado del pedido</h6>
                            <span class="badge bg-info fs-6 px-3 py-2">
                                <i class="bi bi-clock me-1"></i>{{ strtoupper($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="card-footer bg-black border-secondary text-center py-3">
                    <small class="text-secondary">
                        Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} —
                        Gracias por tu compra en <strong class="text-white">Fuerza Urbana</strong>
                    </small>
                </div>
            </div>

            {{-- ACCIONES --}}
            <div class="d-flex gap-3 justify-content-center mt-4">
                <a href="/Catalogos-de-productos" class="btn btn-outline-light px-4">
                    <i class="bi bi-bag me-2"></i>Seguir comprando
                </a>
                <a href="{{ route('cliente.ordenes') }}" class="btn btn-outline-danger px-4">
                    <i class="bi bi-box-seam me-2"></i>Mis pedidos
                </a>
                <button onclick="window.print()" class="btn btn-danger px-4">
                    <i class="bi bi-printer me-2"></i>Imprimir comprobante
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    nav, footer, .d-flex.gap-3 { display: none !important; }
    body { background: white !important; }
    .card { border: 1px solid #ccc !important; color: black !important; }
}
</style>
@endpush
