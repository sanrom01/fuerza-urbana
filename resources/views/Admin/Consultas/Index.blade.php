@extends('layouts.admin')
@section('title', 'Consultas')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h5 class="mb-0 fw-600">Gestión de Consultas</h5>
        <small class="text-muted">Mensajes recibidos desde la página de contacto</small>
    </div>
    @php $pendientes = \App\Models\Consulta::where('estado','pendiente')->count(); @endphp
    @if($pendientes > 0)
    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
        <i class="bi bi-bell me-1"></i>{{ $pendientes }} sin responder
    </span>
    @endif
</div>

<div class="admin-card mb-4 p-3">
    <form class="row g-2 align-items-end filtros-form">
        <div class="col-12 col-md-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Buscar nombre, email o mensaje...">
        </div>
        <div class="col-12 col-md-3">
            <select name="estado" class="form-select">
                <option value="">Todos</option>
                <option value="pendiente"  {{ request('estado')=='pendiente'  ? 'selected':'' }}>Pendientes</option>
                <option value="respondida" {{ request('estado')=='respondida' ? 'selected':'' }}>Respondidas</option>
            </select>
        </div>
        <div class="col-6 col-md-2"><button class="btn btn-dark2 w-100">Filtrar</button></div>
        <div class="col-6 col-md-1">
            <a href="{{ route('admin.consultas.index') }}" class="btn btn-outline-secondary w-100">
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
                <tr><th>ID</th><th>Remitente</th><th>Mensaje</th><th>Fecha</th><th>Estado</th><th class="text-end pe-4">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($consultas as $c)
                <tr>
                    <td class="text-muted small">#{{ $c->id }}</td>
                    <td>
                        <div class="fw-500">{{ $c->nombre }}</div>
                        <small class="text-muted">{{ $c->email }}</small>
                    </td>
                    <td class="small text-muted" style="max-width:260px">
                        {{ Str::limit($c->asunto ?? $c->mensaje, 60) }}
                    </td>
                    <td class="small text-muted" style="white-space:nowrap">
                        {{ $c->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <span class="badge {{ $c->estado=='pendiente' ? 'bg-warning text-dark' : 'bg-success' }}">
                            {{ $c->estado }}
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.consultas.show', $c) }}"
                           class="btn btn-sm {{ $c->estado=='pendiente' ? 'btn-red' : 'btn-outline-secondary' }}">
                            <i class="bi bi-{{ $c->estado=='pendiente' ? 'reply' : 'eye' }} me-1"></i>
                            {{ $c->estado=='pendiente' ? 'Responder' : 'Ver' }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No hay consultas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $consultas->links() }}</div>
</div>

{{-- CARDS móvil --}}
<div class="d-md-none">
    @forelse($consultas as $c)
    <div class="mobile-card">
        <div class="mobile-card-header">
            <div>
                <div class="fw-700">{{ $c->nombre }}</div>
                <div class="text-muted" style="font-size:.8rem">{{ $c->email }}</div>
                <div class="text-muted" style="font-size:.75rem">{{ $c->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <span class="badge {{ $c->estado=='pendiente' ? 'bg-warning text-dark' : 'bg-success' }}">
                {{ $c->estado }}
            </span>
        </div>
        <div class="text-muted small mb-2">{{ Str::limit($c->mensaje, 80) }}</div>
        <a href="{{ route('admin.consultas.show', $c) }}"
           class="btn btn-sm w-100 {{ $c->estado=='pendiente' ? 'btn-red' : 'btn-outline-secondary' }}">
            <i class="bi bi-{{ $c->estado=='pendiente' ? 'reply' : 'eye' }} me-1"></i>
            {{ $c->estado=='pendiente' ? 'Responder' : 'Ver detalle' }}
        </a>
    </div>
    @empty
    <div class="text-center text-muted py-4">No hay consultas.</div>
    @endforelse
    <div class="mt-2">{{ $consultas->links() }}</div>
</div>
@endsection