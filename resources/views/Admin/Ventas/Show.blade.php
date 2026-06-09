@extends('layouts.admin')
@section('title', 'Detalle de venta #'.str_pad($venta->id,5,'0',STR_PAD_LEFT))

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.ventas.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">Pedido #{{ str_pad($venta->id,5,'0',STR_PAD_LEFT) }}</h5>
    @php $colors = ['pendiente'=>'warning','confirmado'=>'info','preparando'=>'secondary','enviado'=>'primary','entregado'=>'success','cancelado'=>'danger']; @endphp
    <span class="badge bg-{{ $colors[$venta->status] ?? 'secondary' }} fs-6 px-3">{{ $venta->status }}</span>
</div>

<div class="row g-4">
    <div class="col-lg-8">

        {{-- PRODUCTOS --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h6><i class="bi bi-bag me-2"></i>Productos del pedido</h6>
            </div>
            <table class="table table-admin">
                <thead><tr><th>Producto</th><th class="text-center">Cant.</th><th class="text-end">Precio unit.</th><th class="text-end pe-4">Subtotal</th></tr></thead>
                <tbody>
                    @foreach($venta->items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $item->product->images->where('is_main',true)->first()?->url ?? 'https://picsum.photos/seed/'.$item->product_id.'/44/44' }}"
                                     style="width:44px;height:44px;object-fit:cover;border-radius:8px">
                                <span class="fw-500">{{ $item->product_name }}</span>
                            </div>
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">${{ number_format($item->unit_price,0,',','.') }}</td>
                        <td class="text-end pe-4 fw-600">${{ number_format($item->subtotal,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr><td colspan="3" class="text-end fw-500">Subtotal</td><td class="text-end pe-4">${{ number_format($venta->subtotal,0,',','.') }}</td></tr>
                    <tr><td colspan="3" class="text-end fw-500">Envío</td><td class="text-end pe-4">${{ number_format($venta->shipping_cost,0,',','.') }}</td></tr>
                    <tr><td colspan="3" class="text-end fw-600 fs-6">Total</td><td class="text-end pe-4 fw-700 fs-6 text-danger">${{ number_format($venta->total,0,',','.') }}</td></tr>
                </tfoot>
            </table>
        </div>

        {{-- CAMBIAR ESTADO --}}
        <div class="admin-card mt-3 p-4">
            <h6 class="fw-600 mb-3">Cambiar estado del pedido</h6>
            <form action="{{ route('admin.ventas.estado', $venta) }}" method="POST" class="d-flex gap-2">
                @csrf @method('PATCH')
                <select name="status" class="form-select">
                    @foreach(['pendiente','confirmado','preparando','enviado','entregado','cancelado'] as $s)
                    <option value="{{ $s }}" {{ $venta->status==$s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-red px-4">Actualizar</button>
            </form>
            @if(!$venta->factura && $venta->status === 'confirmado')
            <small class="text-muted d-block mt-2">
                <i class="bi bi-info-circle me-1"></i>
                Al confirmar se generará la factura automáticamente.
            </small>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        {{-- DATOS DEL CLIENTE --}}
        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3"><i class="bi bi-person me-2"></i>Cliente</h6>
            <div class="fw-500">{{ $venta->user->name }}</div>
            <div class="text-muted small">{{ $venta->user->email }}</div>
            <div class="text-muted small">{{ $venta->user->phone ?? '—' }}</div>
            <a href="{{ route('admin.usuarios.show', $venta->user) }}" class="btn btn-sm btn-outline-secondary mt-2">
                Ver perfil
            </a>
        </div>

        {{-- DIRECCIÓN --}}
        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3"><i class="bi bi-geo-alt me-2"></i>Dirección de envío</h6>
            <div>{{ $venta->address->street }}</div>
            <div class="text-muted small">{{ $venta->address->city }}, {{ $venta->address->province }}</div>
            <div class="text-muted small">CP: {{ $venta->address->postal_code }}</div>
        </div>

        {{-- PAGO --}}
        @if($venta->payment)
        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3"><i class="bi bi-credit-card me-2"></i>Pago</h6>
            <div><span class="badge bg-secondary">{{ $venta->payment->method }}</span></div>
            <div class="mt-1">
                <span class="badge bg-{{ $venta->payment->status=='aprobado' ? 'success' : 'danger' }}">
                    {{ $venta->payment->status }}
                </span>
            </div>
            @if($venta->payment->transaction_id)
            <div class="text-muted small mt-1">TXN: {{ $venta->payment->transaction_id }}</div>
            @endif
        </div>
        @endif

        {{-- FACTURA --}}
        @if($venta->factura)
        <div class="admin-card p-4">
            <h6 class="fw-600 mb-3"><i class="bi bi-receipt me-2"></i>Factura</h6>
            <div class="fw-500">{{ $venta->factura->numero }}</div>
            <div class="d-flex gap-2 mt-2">
                <a href="{{ route('admin.facturacion.show', $venta->factura) }}" class="btn btn-sm btn-outline-secondary">
                    Ver factura
                </a>
                <a href="{{ route('admin.facturacion.pdf', $venta->factura) }}" class="btn btn-sm btn-red">
                    <i class="bi bi-download me-1"></i>PDF
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection