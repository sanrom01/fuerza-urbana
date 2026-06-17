@extends('layouts.admin')
@section('title', isset($producto) ? 'Editar producto' : 'Nuevo producto')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.productos.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">{{ isset($producto) ? 'Editar: '.$producto->name : 'Nuevo producto' }}</h5>
</div>

<form action="{{ isset($producto) ? route('admin.productos.update', $producto) : route('admin.productos.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($producto)) @method('PUT') @endif

    @if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">

            {{-- INFO GENERAL --}}
            <div class="admin-card p-4 mb-3">
                <h6 class="fw-600 mb-3">Información del producto</h6>
                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $producto->name ?? '') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="3"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $producto->description ?? '') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Categoría *</label>
                        <select name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Seleccioná una categoría</option>
                            @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $producto->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control"
                               value="{{ old('sku', $producto->sku ?? '') }}" placeholder="REM-001">
                    </div>
                </div>
            </div>

            {{-- PRECIOS --}}
            <div class="admin-card p-4 mb-3">
                <h6 class="fw-600 mb-3">Precios</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Precio *</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="price" step="0.01" min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $producto->price ?? '') }}" required>
                        </div>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Precio de oferta</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="sale_price" step="0.01" min="0"
                                   class="form-control"
                                   value="{{ old('sale_price', $producto->sale_price ?? '') }}"
                                   placeholder="Vacío = sin oferta">
                        </div>
                    </div>
                </div>
            </div>

            {{-- STOCK POR TALLE ← NUEVO --}}
            <div class="admin-card p-4 mb-3">
                <h6 class="fw-600 mb-1">Stock por talle</h6>
                <p class="text-muted small mb-3">
                    Ingresá la cantidad disponible de cada talle. Dejá en 0 los que no tenés.
                </p>

                <div class="row g-3">
                    @foreach($tallesDisponibles as $talle)
                    @php
                        // En edición cargar el stock actual del talle, en creación usar old()
                        $stockActual = old('stock_talles.'.$talle,
                            isset($producto)
                                ? ($producto->talles->where('talle', $talle)->first()?->stock ?? 0)
                                : 0
                        );
                    @endphp
                    <div class="col-4 col-md-2">
                        <label class="form-label fw-600 text-center d-block">{{ $talle }}</label>
                        <input type="number"
                               name="stock_talles[{{ $talle }}]"
                               min="0" value="{{ $stockActual }}"
                               class="form-control text-center"
                               style="{{ $stockActual > 0 ? 'border-color:#198754' : '' }}">
                    </div>
                    @endforeach
                </div>

                {{-- Totalizador --}}
                <div class="mt-3 p-3 rounded-3" style="background:#f8f7fd">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Stock total calculado:</span>
                        <span class="fw-700 fs-5" id="stockTotal">
                            {{ isset($producto) ? $producto->talles->sum('stock') : 0 }}
                        </span>
                    </div>
                    <small class="text-muted">Se actualiza automáticamente al cambiar los talles.</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4">

            {{-- IMAGEN --}}
            <div class="admin-card p-4 mb-3">
                <h6 class="fw-600 mb-3">Imagen principal</h6>
                @if(isset($producto) && $producto->images->where('is_main',true)->first())
                <img src="{{ $producto->images->where('is_main',true)->first()->url }}"
                     class="w-100 rounded-3 mb-3" style="height:180px;object-fit:cover">
                @endif
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <small class="text-muted">JPG, PNG o WebP. Máx 2MB.</small>
            </div>

            {{-- OPCIONES --}}
            <div class="admin-card p-4 mb-3">
                <h6 class="fw-600 mb-3">Opciones</h6>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox"
                           name="is_active" value="1" id="chkActivo"
                           {{ old('is_active', $producto->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="chkActivo">Producto activo</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox"
                           name="featured" value="1" id="chkFeatured"
                           {{ old('featured', $producto->featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="chkFeatured">Destacado en la tienda</label>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-red py-2">
                    <i class="bi bi-check-lg me-1"></i>
                    {{ isset($producto) ? 'Guardar cambios' : 'Crear producto' }}
                </button>
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Calcular stock total en tiempo real
document.querySelectorAll('input[name^="stock_talles"]').forEach(function(input) {
    input.addEventListener('input', function() {
        var total = 0;
        document.querySelectorAll('input[name^="stock_talles"]').forEach(function(i) {
            total += parseInt(i.value) || 0;
            // Colorear el campo según stock
            i.style.borderColor = parseInt(i.value) > 0 ? '#198754' : '';
        });
        document.getElementById('stockTotal').textContent = total;
    });
});
</script>
@endpush