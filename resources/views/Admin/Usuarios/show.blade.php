@extends('layouts.admin')
@section('title', 'Usuario: '.$usuario->name)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">{{ $usuario->name }}</h5>
    <span class="badge {{ $usuario->role=='admin' ? 'bg-danger' : 'bg-light text-dark border' }}">{{ $usuario->role }}</span>
    @if($usuario->trashed())
        <span class="badge bg-danger">Inactivo</span>
    @else
        <span class="badge bg-success">Activo</span>
    @endif
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="admin-card p-4 text-center mb-3">
            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                 style="width:80px;height:80px;font-size:2rem;font-weight:700">
                {{ strtoupper(substr($usuario->name,0,2)) }}
            </div>
            <h5 class="fw-600 mb-1">{{ $usuario->name }}</h5>
            <p class="text-muted small mb-3">{{ $usuario->email }}</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-red btn-sm px-3">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
                @if(!$usuario->trashed() && $usuario->id !== auth()->id())
                <form action="{{ route('admin.usuarios.desactivar', $usuario) }}" method="POST"
                      onsubmit="return confirm('¿Desactivar este usuario?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-person-x me-1"></i>Desactivar
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="admin-card p-4">
            <h6 class="fw-600 mb-3">Datos de contacto</h6>
            <table class="table table-sm mb-0">
                <tr><td class="text-muted small">Teléfono</td><td class="small">{{ $usuario->phone ?? '—' }}</td></tr>
                <tr><td class="text-muted small">Registrado</td><td class="small">{{ $usuario->created_at->format('d/m/Y') }}</td></tr>
                <tr><td class="text-muted small">Última actualización</td><td class="small">{{ $usuario->updated_at->format('d/m/Y') }}</td></tr>
            </table>
        </div>
    </div>

    <div class="col-lg-8">

        {{-- RESUMEN DE COMPRAS --}}
        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3"><i class="bi bi-bag-check me-2 text-danger"></i>Resumen de compras</h6>
            <div class="row g-3 text-center">
                <div class="col-4">
                    <div class="p-3 rounded-3" style="background:#f0fff4">
                        <div class="fw-700 fs-4 text-success">{{ $usuario->orders->where('status','!=','cancelado')->count() }}</div>
                        <small class="text-muted">Órdenes</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 rounded-3" style="background:#f8f7fd">
                        <div class="fw-700 fs-4">${{ number_format($usuario->orders->where('status','!=','cancelado')->sum('total'),0,',','.') }}</div>
                        <small class="text-muted">Total gastado</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 rounded-3" style="background:#fff0f0">
                        <div class="fw-700 fs-4 text-danger">{{ $usuario->orders->where('status','cancelado')->count() }}</div>
                        <small class="text-muted">Canceladas</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- HISTORIAL DE ÓRDENES --}}
        <div class="admin-card mb-3">
            <div class="admin-card-header">
                <h6><i class="bi bi-clock-history me-2"></i>Historial de órdenes</h6>
            </div>
            <table class="table table-admin">
                <thead><tr><th>#Pedido</th><th>Fecha</th><th>Total</th><th>Estado</th><th class="text-end pe-4">Ver</th></tr></thead>
                <tbody>
                    @php $colors = ['pendiente'=>'warning','confirmado'=>'info','preparando'=>'secondary','enviado'=>'primary','entregado'=>'success','cancelado'=>'danger']; @endphp
                    @forelse($usuario->orders->sortByDesc('created_at')->take(8) as $o)
                    <tr>
                        <td class="fw-600">#{{ str_pad($o->id,5,'0',STR_PAD_LEFT) }}</td>
                        <td class="small text-muted">{{ $o->created_at->format('d/m/Y') }}</td>
                        <td class="fw-500">${{ number_format($o->total,0,',','.') }}</td>
                        <td><span class="badge bg-{{ $colors[$o->status] ?? 'secondary' }}">{{ $o->status }}</span></td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.ventas.show', $o) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Sin órdenes registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- DIRECCIONES --}}
        @if($usuario->addresses->count())
        <div class="admin-card p-4">
            <h6 class="fw-600 mb-3"><i class="bi bi-geo-alt me-2"></i>Direcciones registradas</h6>
            @foreach($usuario->addresses as $dir)
            <div class="p-3 rounded-3 mb-2" style="background:#f8f7fd">
                <div class="fw-500 small">{{ $dir->street }}</div>
                <div class="text-muted small">{{ $dir->city }}, {{ $dir->province }} — CP {{ $dir->postal_code }}</div>
                @if($dir->is_default)<span class="badge bg-success mt-1" style="font-size:.65rem">Predeterminada</span>@endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection