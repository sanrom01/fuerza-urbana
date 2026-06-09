{{-- ═══════ resources/views/admin/consultas/index.blade.php ═══════ --}}
@extends('layouts.admin')
@section('title', 'Consultas')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-600">Gestión de Consultas</h5>
</div>
<div class="admin-card mb-4 p-3">
    <form class="row g-2">
        <div class="col-md-3">
            <select name="estado" class="form-select">
                <option value="">Todos</option>
                <option value="pendiente"  {{ request('estado')=='pendiente'  ? 'selected':'' }}>Pendientes</option>
                <option value="respondida" {{ request('estado')=='respondida' ? 'selected':'' }}>Respondidas</option>
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-dark2 w-100">Filtrar</button></div>
    </form>
</div>
<div class="admin-card">
    <table class="table table-admin">
        <thead><tr><th>ID</th><th>Remitente</th><th>Asunto</th><th>Fecha</th><th>Estado</th><th class="text-end pe-4">Acciones</th></tr></thead>
        <tbody>
            @forelse($consultas as $c)
            <tr>
                <td class="text-muted small">#{{ $c->id }}</td>
                <td>
                    <div class="fw-500">{{ $c->nombre }}</div>
                    <small class="text-muted">{{ $c->email }}</small>
                </td>
                <td class="small">{{ Str::limit($c->asunto ?? $c->mensaje, 50) }}</td>
                <td class="small text-muted">{{ $c->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="badge {{ $c->estado=='pendiente' ? 'bg-warning text-dark' : 'bg-success' }}">
                        {{ $c->estado }}
                    </span>
                </td>
                <td class="text-end pe-4">
                    <a href="{{ route('admin.consultas.show', $c) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-eye me-1"></i>Ver
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No hay consultas registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-3 py-2">{{ $consultas->links() }}</div>
</div>
@endsection