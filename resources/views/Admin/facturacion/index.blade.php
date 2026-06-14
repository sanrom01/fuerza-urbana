@extends('layouts.admin')
@section('title', 'Facturación')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="mb-0 fw-600">Facturación</h5>
        <small class="text-muted">Todas las facturas emitidas</small>
    </div>
</div>

<div class="admin-card">
    <table class="table table-admin">
        <thead>
            <tr>
                <th>Nº Factura</th>
                <th>Cliente</th>
                <th>Pedido</th>
                <th>Fecha</th>
                <th class="text-end">Total</th>
                <th>Estado</th>
                <th class="text-end pe-4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $f)
            <tr>
                <td class="fw-600 text-danger">{{ $f->numero }}</td>
                <td>
                    <div class="fw-500">{{ $f->user->name }}</div>
                    <small class="text-muted">{{ $f->user->email }}</small>
                </td>
                <td>
                    <a href="{{ route('admin.ventas.show', $f->order) }}"
                       class="text-decoration-none">
                        #{{ str_pad($f->order_id, 5, '0', STR_PAD_LEFT) }}
                    </a>
                </td>
                <td class="small text-muted">{{ $f->created_at->format('d/m/Y H:i') }}</td>
                <td class="text-end fw-600">${{ number_format($f->total, 0, ',', '.') }}</td>
                <td>
                    <span class="badge {{ $f->estado == 'emitida' ? 'bg-success' : 'bg-danger' }}">
                        {{ $f->estado }}
                    </span>
                </td>
                <td class="text-end pe-4">
                    <a href="{{ route('admin.facturacion.show', $f) }}"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('admin.facturacion.pdf', $f) }}"
                       class="btn btn-sm btn-red" title="Descargar PDF">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-receipt fs-3 d-block mb-2 opacity-25"></i>
                    No hay facturas emitidas aún.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-3 py-2">{{ $facturas->links() }}</div>
</div>
@endsection