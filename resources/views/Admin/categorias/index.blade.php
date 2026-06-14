@extends('layouts.admin')
@section('title', 'Categorías')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h5 class="mb-0 fw-600">Gestión de Categorías</h5>
        <small class="text-muted d-none d-sm-block">Categorías y subcategorías del catálogo</small>
    </div>
    <a href="{{ route('admin.categorias.create') }}" class="btn btn-red btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nueva categoría
    </a>
</div>

{{-- TABLA desktop --}}
<div class="admin-card d-none d-md-block">
    <div class="table-responsive-admin">
        <table class="table table-admin">
            <thead>
                <tr>
                    <th>ID</th><th>Nombre</th><th>Slug</th><th>Descripción</th>
                    <th class="text-center">Productos</th><th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $cat)
                <tr @if($cat->trashed()) style="opacity:.55;background:#fdf5f5" @endif>
                    <td class="text-muted small">#{{ $cat->id }}</td>
                    <td>
                        <div class="fw-500">
                            @if($cat->parent_id)
                                <i class="bi bi-arrow-return-right text-muted me-1"></i>
                            @endif
                            {{ $cat->name }}
                        </div>
                        @if($cat->parent_id)
                            <small class="text-muted">Subcategoría</small>
                        @endif
                    </td>
                    <td><code class="small text-muted">{{ Str::limit($cat->slug, 25) }}</code></td>
                    <td class="text-muted small">{{ Str::limit($cat->description, 45) ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border">{{ $cat->products_count }}</span>
                    </td>
                    <td>
                        @if($cat->trashed())     <span class="badge bg-danger">Eliminada</span>
                        @elseif($cat->is_active) <span class="badge bg-success">Activa</span>
                        @else                    <span class="badge bg-secondary">Inactiva</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        @if($cat->trashed())
                            <form action="{{ route('admin.categorias.restore', $cat->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.categorias.edit', $cat) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categorias.destroy', $cat) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar {{ addslashes($cat->name) }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"
                                        {{ $cat->products_count > 0 ? 'disabled' : '' }}
                                        title="{{ $cat->products_count > 0 ? 'Tiene productos' : 'Eliminar' }}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-tag fs-3 d-block mb-2 opacity-25"></i>
                        No hay categorías registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $categorias->links() }}</div>
</div>

{{-- CARDS móvil --}}
<div class="d-md-none">
    @forelse($categorias as $cat)
    <div class="mobile-card" @if($cat->trashed()) style="opacity:.6" @endif>
        <div class="mobile-card-header">
            <div>
                <div class="fw-700">
                    @if($cat->parent_id)
                        <i class="bi bi-arrow-return-right text-muted me-1" style="font-size:.8rem"></i>
                    @endif
                    {{ $cat->name }}
                </div>
                <div class="text-muted" style="font-size:.75rem">
                    {{ $cat->parent_id ? 'Subcategoría' : 'Categoría padre' }}
                    · {{ $cat->products_count }} productos
                </div>
            </div>
            <div>
                @if($cat->trashed())     <span class="badge bg-danger">Eliminada</span>
                @elseif($cat->is_active) <span class="badge bg-success">Activa</span>
                @else                    <span class="badge bg-secondary">Inactiva</span>
                @endif
            </div>
        </div>
        @if($cat->description)
        <div class="text-muted small mb-2">{{ Str::limit($cat->description, 60) }}</div>
        @endif
        <div class="d-flex gap-2 mt-2">
            @if($cat->trashed())
                <form action="{{ route('admin.categorias.restore', $cat->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    <button class="btn btn-sm btn-outline-success w-100">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Restaurar
                    </button>
                </form>
            @else
                <a href="{{ route('admin.categorias.edit', $cat) }}"
                   class="btn btn-sm btn-outline-primary flex-grow-1">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
                @if($cat->products_count == 0)
                <form action="{{ route('admin.categorias.destroy', $cat) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar {{ addslashes($cat->name) }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger px-3">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
                @endif
            @endif
        </div>
    </div>
    @empty
    <div class="text-center text-muted py-4">
        <i class="bi bi-tag fs-3 d-block mb-2 opacity-25"></i>
        No hay categorías registradas.
    </div>
    @endforelse
    <div class="mt-2">{{ $categorias->links() }}</div>
</div>
@endsection