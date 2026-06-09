@extends('layouts.admin')
@section('title', 'Productos')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="mb-0 fw-600">Gestión de Productos</h5>
        <small class="text-muted">CRUD completo con baja lógica</small>
    </div>
    <a href="{{ route('admin.productos.create') }}" class="btn btn-red">
        <i class="bi bi-plus-lg me-1"></i> Nuevo producto
    </a>
</div>

{{-- FILTROS --}}
<div class="admin-card mb-4 p-3">
    <form class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Buscar por nombre…">
        </div>
        <div class="col-md-3">
            <select name="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="estado" class="form-select">
                <option value="">Activos</option>
                <option value="inactivo"   {{ request('estado')=='inactivo'   ? 'selected':'' }}>Inactivos</option>
                <option value="eliminado"  {{ request('estado')=='eliminado'  ? 'selected':'' }}>Eliminados</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark2 w-100">Filtrar</button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary w-100" title="Limpiar">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </form>
</div>

{{-- TABLA --}}
<div class="admin-card">
    <table class="table table-admin">
        <thead>
            <tr>
                <th>ID</th><th>Imagen</th><th>Nombre</th><th>Categoría</th>
                <th>Precio</th><th>Stock</th><th>Estado</th><th class="text-end pe-4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $p)
            <tr @if($p->trashed()) style="opacity:.55;background:#fdf5f5" @endif>
                <td class="text-muted small">#{{ $p->id }}</td>
                <td>
                    <img src="{{ $p->images->where('is_main',true)->first()?->url ?? 'https://picsum.photos/seed/'.$p->id.'/48/48' }}"
                         style="width:44px;height:44px;object-fit:cover;border-radius:8px">
                </td>
                <td>
                    <div class="fw-500">{{ $p->name }}</div>
                    @if($p->featured)<span class="badge bg-warning text-dark" style="font-size:.65rem">Destacado</span>@endif
                </td>
                <td><span class="badge bg-light text-dark border">{{ $p->category->name }}</span></td>
                <td>
                    @if($p->sale_price)
                        <span class="text-danger fw-600">${{ number_format($p->sale_price,0,',','.') }}</span>
                        <br><small class="text-muted text-decoration-line-through">${{ number_format($p->price,0,',','.') }}</small>
                    @else
                        ${{ number_format($p->price,0,',','.') }}
                    @endif
                </td>
                <td>
                    <span class="{{ $p->stock == 0 ? 'text-danger fw-600' : ($p->stock <= $p->stock_min ? 'text-warning fw-600' : '') }}">
                        {{ $p->stock }}
                    </span>
                </td>
                <td>
                    @if($p->trashed())
                        <span class="badge bg-danger">Eliminado</span>
                    @elseif($p->is_active)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>
                <td class="text-end pe-4">
                    @if($p->trashed())
                        <form action="{{ route('admin.productos.restore', $p->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-outline-success" title="Restaurar">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('admin.productos.show', $p) }}" class="btn btn-sm btn-outline-secondary" title="Ver">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.productos.edit', $p) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.productos.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No se encontraron productos.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-3 py-2">{{ $productos->links() }}</div>
</div>
@endsection