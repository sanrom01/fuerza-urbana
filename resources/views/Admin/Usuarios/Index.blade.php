{{-- ═══════ resources/views/admin/usuarios/index.blade.php ═══════ --}}
@extends('layouts.admin')
@section('title', 'Usuarios')
@section('content')
<h5 class="fw-600 mb-4">Gestión de Usuarios</h5>

<div class="admin-card mb-4 p-3">
    <form class="row g-2 align-items-end">
        <div class="col-md-5"><input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por nombre o email…"></div>
        <div class="col-md-3">
            <select name="rol" class="form-select">
                <option value="">Todos los roles</option>
                <option value="admin"   {{ request('rol')=='admin'   ? 'selected':'' }}>Admin</option>
                <option value="cliente" {{ request('rol')=='cliente' ? 'selected':'' }}>Cliente</option>
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-dark2 w-100">Filtrar</button></div>
        <div class="col-md-1"><a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-x-lg"></i></a></div>
    </form>
</div>

<div class="admin-card">
    <table class="table table-admin">
        <thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Rol</th><th>Estado</th><th>Registro</th><th class="text-end pe-4">Acciones</th></tr></thead>
        <tbody>
            @forelse($usuarios as $u)
            <tr @if($u->trashed()) style="opacity:.5;background:#fdf5f5" @endif>
                <td class="text-muted small">#{{ $u->id }}</td>
                <td class="fw-500">{{ $u->name }}</td>
                <td class="text-muted small">{{ $u->email }}</td>
                <td class="text-muted small">{{ $u->phone ?? '—' }}</td>
                <td><span class="badge {{ $u->role=='admin' ? 'bg-danger' : 'bg-light text-dark border' }}">{{ $u->role }}</span></td>
                <td>
                    @if($u->trashed()) <span class="badge bg-danger">Inactivo</span>
                    @else <span class="badge bg-success">Activo</span> @endif
                </td>
                <td class="small text-muted">{{ $u->created_at->format('d/m/Y') }}</td>
                <td class="text-end pe-4">
                    <a href="{{ route('admin.usuarios.show', $u) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.usuarios.edit', $u) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    @if($u->trashed())
                        <form action="{{ route('admin.usuarios.restore', $u->id) }}" method="POST" class="d-inline">
                            @csrf <button class="btn btn-sm btn-outline-success" title="Restaurar"><i class="bi bi-arrow-counterclockwise"></i></button>
                        </form>
                    @elseif($u->id !== auth()->id())
                        <form action="{{ route('admin.usuarios.desactivar', $u) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Desactivar este usuario?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-person-x"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No se encontraron usuarios.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-3 py-2">{{ $usuarios->links() }}</div>
</div>
@endsection