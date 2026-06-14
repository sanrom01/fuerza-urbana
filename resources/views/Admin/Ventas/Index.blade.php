@extends('layouts.admin')
@section('title', 'Ventas')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <h5 class="mb-0 fw-600">Gestión de Ventas</h5>
</div>

{{-- FILTROS --}}
<div class="admin-card mb-4 p-3">
    <form class="row g-2 align-items-end filtros-form">
        <div class="col-12 col-md-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Buscar cliente o #pedido…">
        </div>
        <div class="col-12 col-md-3">
            <select name="estado" class="form-select">
                <option value="">Todos los estados</option>
                @foreach(['pendiente','confirmado','preparando','enviado','entregado','cancelado'] as $s)
                <option value="{{ $s }}" {{ request('estado')==$s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-2">
            <button class="btn btn-dark2 w-100">Filtrar</button>
        </div>
        <div class="col-6 col-md-1">
            <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </form>
</div>

{{-- TABLA desktop --}}
<div class="admin-card d-none d-md-block">
    <div class="table-responsive-admin">
        <table class="table table-admin">
            <thead>
                <tr>
                    <th>#Pedido</th><th>Cliente</th><th>Fecha</th>
                    <th>Total</th><th>Pago</th><th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $colors = ['pendiente'=>'warning','confirmado'=>'info','preparando'=>'secondary','enviado'=>'primary','entregado'=>'success','cancelado'=>'danger']; @endphp
                @forelse($ventas as $v)
                <tr>
                    <td class="fw-600">#{{ str_pad($v->id,5,'0',STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="fw-500">{{ $v->user->name }}</div>
                        <small class="text-muted">{{ $v->user->email }}</small>
                    </td>
                    <td class="small text-muted">{{ $v->created_at->format('d/m/Y H:i') }}</td>
                    <td class="fw-600">${{ number_format($v->total,0,',','.') }}</td>
                    <td>
                        @if($v->payment)
                        <span class="badge bg-{{ $v->payment->status=='aprobado' ? 'success' : ($v->payment->status=='pendiente' ? 'warning' : 'danger') }}">
                            {{ $v->payment->status }}
                        </span>
                        @else
                        <span class="badge bg-light text-muted">—</span>
                        @endif
                    </td>
                    <td><span class="badge bg-{{ $colors[$v->status] ?? 'secondary' }}">{{ $v->status }}</span></td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.ventas.show', $v) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No hay ventas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $ventas->links() }}</div>
</div>

{{-- CARDS móvil --}}
<div class="d-md-none">
    @php $colors = ['pendiente'=>'warning','confirmado'=>'info','preparando'=>'secondary','enviado'=>'primary','entregado'=>'success','cancelado'=>'danger']; @endphp
    @forelse($ventas as $v)
    <div class="mobile-card">
        <div class="mobile-card-header">
            <div>
                <div class="fw-700">#{{ str_pad($v->id,5,'0',STR_PAD_LEFT) }}</div>
                <div class="fw-500 small">{{ $v->user->name }}</div>
                <div class="text-muted" style="font-size:.75rem">{{ $v->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <span class="badge bg-{{ $colors[$v->status] ?? 'secondary' }}">{{ $v->status }}</span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-700 text-danger">${{ number_format($v->total,0,',','.') }}</span>
                @if($v->payment)
                <span class="badge bg-{{ $v->payment->status=='aprobado' ? 'success' : 'warning' }} ms-2" style="font-size:.65rem">
                    {{ $v->payment->status }}
                </span>
                @endif
            </div>
            <a href="{{ route('admin.ventas.show', $v) }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-eye me-1"></i>Ver
            </a>
        </div>
    </div>
    @empty
    <div class="text-center text-muted py-4">No hay ventas registradas.</div>
    @endforelse
    <div class="mt-2">{{ $ventas->links() }}</div>
</div>
@endsection