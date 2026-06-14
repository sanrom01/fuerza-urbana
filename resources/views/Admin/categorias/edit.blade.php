@extends('layouts.admin')
@section('title', 'Editar: '.$categoria->name)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.categorias.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">Editar: {{ $categoria->name }}</h5>
    @if($categoria->parent_id)
        <span class="badge bg-light text-dark border">Subcategoría</span>
    @else
        <span class="badge bg-dark text-white">Categoría padre</span>
    @endif
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-card p-4">

            @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST">
                @csrf @method('PUT')

                {{-- CATEGORÍA PADRE --}}
                <div class="mb-3">
                    <label class="form-label">Categoría padre</label>
                    <select name="parent_id" class="form-select">
                        <option value="">— Sin padre (es categoría principal) —</option>
                        @foreach($padres as $p)
                        <option value="{{ $p->id }}"
                                {{ old('parent_id', $categoria->parent_id) == $p->id ? 'selected':'' }}>
                            {{ $p->name }}
                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Dejá vacío si es categoría principal. Seleccioná una para hacerla subcategoría.</small>
                </div>

                {{-- NOMBRE --}}
                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $categoria->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- SLUG (solo lectura) --}}
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" value="{{ $categoria->slug }}"
                           disabled style="opacity:.6">
                    <small class="text-muted">El slug no se puede editar una vez creado.</small>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="3" class="form-control"
                              placeholder="Descripción breve (opcional)">{{ old('description', $categoria->description) }}</textarea>
                </div>

                {{-- ORDEN --}}
                <div class="mb-3">
                    <label class="form-label">Orden de aparición</label>
                    <input type="number" name="sort_order" min="0"
                           class="form-control" value="{{ old('sort_order', $categoria->sort_order) }}"
                           style="width:120px">
                </div>

                {{-- STATS --}}
                <div class="row g-2 mb-4">
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background:#f8f7fd">
                            <div class="fw-700">{{ $categoria->products()->count() }}</div>
                            <small class="text-muted">Productos</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background:#f8f7fd">
                            <div class="fw-700">{{ $categoria->children()->count() }}</div>
                            <small class="text-muted">Subcategorías</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background:#f8f7fd">
                            <div class="fw-700">{{ $categoria->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">Creada</small>
                        </div>
                    </div>
                </div>

                {{-- ESTADO --}}
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                               name="is_active" value="1" id="chkActivo"
                               {{ old('is_active', $categoria->is_active) ? 'checked':'' }}>
                        <label class="form-check-label" for="chkActivo">
                            Categoría activa (visible en la tienda)
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-red px-4">
                        <i class="bi bi-check-lg me-1"></i>Guardar cambios
                    </button>
                    <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        {{-- SUBCATEGORÍAS HIJAS (si es padre) --}}
        @if(!$categoria->parent_id && $categoria->children->count())
        <div class="admin-card mt-3">
            <div class="admin-card-header">
                <h6><i class="bi bi-diagram-3 me-2"></i>Subcategorías de {{ $categoria->name }}</h6>
                <a href="{{ route('admin.categorias.create') }}" class="btn btn-sm btn-red">
                    <i class="bi bi-plus me-1"></i>Nueva subcategoría
                </a>
            </div>
            <table class="table table-admin">
                <thead><tr><th>Nombre</th><th class="text-center">Productos</th><th>Estado</th><th class="text-end pe-3">Editar</th></tr></thead>
                <tbody>
                    @foreach($categoria->children as $sub)
                    <tr>
                        <td class="fw-500"><i class="bi bi-arrow-return-right me-1 text-muted"></i>{{ $sub->name }}</td>
                        <td class="text-center"><span class="badge bg-light text-dark border">{{ $sub->products()->count() }}</span></td>
                        <td><span class="badge {{ $sub->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $sub->is_active ? 'Activa' : 'Inactiva' }}</span></td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.categorias.edit', $sub) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection