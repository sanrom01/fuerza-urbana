@extends('layouts.admin')
@section('title', 'Productos')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h5 class="mb-0 fw-600">Gestión de Productos</h5>
        <small class="text-muted d-none d-sm-block">CRUD completo con baja lógica</small>
    </div>
    <a href="{{ route('admin.productos.create') }}" class="btn btn-red btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nuevo producto
    </a>
</div>

{{-- FILTROS --}}
<div class="admin-card mb-4 p-3">
    <form class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Buscar por nombre…">
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <select name="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-sm-3 col-md-2">
            <select name="estado" class="form-select">
                <option value="">Activos</option>
                <option value="inactivo"  {{ request('estado')=='inactivo'  ? 'selected':'' }}>Inactivos</option>
                <option value="eliminado" {{ request('estado')=='eliminado' ? 'selected':'' }}>Eliminados</option>
            </select>
        </div>
        <div class="col-4 col-sm-3 col-md-2">
            <button type="submit" class="btn btn-dark2 w-100">Filtrar</button>
        </div>
        <div class="col-2 col-md-1">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary w-100">
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
                    <th>ID</th><th>Imagen</th><th>Nombre</th><th>Categoría</th>
                    <th>Precio</th><th>Stock</th><th>Estado</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $p)
                <tr @if($p->trashed()) style="opacity:.55;background:#fdf5f5" @endif>
                    <td class="text-muted small">#{{ $p->id }}</td>
                    <td>
                        <img src="{{ $p->images->where('is_main',true)->first()?->url ?? 'https://picsum.photos/seed/'.$p->id.'/48/48' }}"
                             style="width:44px;height:44px;object-fit:cover;border-radius:8px"
                             onerror="this.src='https://picsum.photos/seed/{{ $p->id }}/48/48'">
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
                        @if($p->trashed())     <span class="badge bg-danger">Eliminado</span>
                        @elseif($p->is_active) <span class="badge bg-success">Activo</span>
                        @else                  <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td class="text-end pe-4">
                        @if($p->trashed())
                            <form action="{{ route('admin.productos.restore', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </form>
                        @else
                            <a href="{{ route('admin.productos.show', $p) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.productos.edit', $p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.productos.destroy', $p) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No se encontraron productos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $productos->links() }}</div>
</div>

{{-- CARDS móvil --}}
<div class="d-md-none">
    @forelse($productos as $p)
    <div class="mobile-card" @if($p->trashed()) style="opacity:.6" @endif>
        <div class="d-flex gap-3 align-items-start">
            <img src="{{ $p->images->where('is_main',true)->first()?->url ?? 'https://picsum.photos/seed/'.$p->id.'/60/60' }}"
                 style="width:60px;height:60px;object-fit:cover;border-radius:10px;flex-shrink:0"
                 onerror="this.src='https://picsum.photos/seed/{{ $p->id }}/60/60'">
            <div class="flex-grow-1 min-width-0">
                <div class="fw-700 text-truncate">{{ $p->name }}</div>
                <div class="text-muted small">{{ $p->category->name }}</div>
                <div class="d-flex gap-2 align-items-center mt-1 flex-wrap">
                    <span class="fw-700 text-danger">
                        ${{ number_format($p->sale_price ?? $p->price, 0, ',', '.') }}
                    </span>
                    <span class="badge {{ $p->stock==0 ? 'bg-danger' : ($p->is_active ? 'bg-success' : 'bg-secondary') }}" style="font-size:.65rem">
                        {{ $p->stock==0 ? 'Sin stock' : ($p->is_active ? 'Activo' : 'Inactivo') }}
                    </span>
                </div>
            </div>
            <div class="text-end" style="font-size:.8rem;color:#888;flex-shrink:0">
                Stock: <strong>{{ $p->stock }}</strong>
            </div>
        </div>
        <div class="d-flex gap-2 mt-3">
            @if($p->trashed())
                <form action="{{ route('admin.productos.restore', $p->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    <button class="btn btn-sm btn-outline-success w-100">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Restaurar
                    </button>
                </form>
            @else
                <a href="{{ route('admin.productos.show', $p) }}" class="btn btn-sm btn-outline-secondary flex-grow-1">
                    <i class="bi bi-eye me-1"></i>Ver
                </a>
                <a href="{{ route('admin.productos.edit', $p) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
                <form action="{{ route('admin.productos.destroy', $p) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger px-3"><i class="bi bi-trash3"></i></button>
                </form>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center text-muted py-4">No se encontraron productos.</div>
    @endforelse
    <div class="mt-2">{{ $productos->links() }}</div>
</div>
@endsection