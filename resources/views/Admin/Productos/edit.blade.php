@extends('layouts.admin')
@section('title', isset($producto) ? 'Editar producto' : 'Nuevo producto')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.productos.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="mb-0 fw-600">{{ isset($producto) ? 'Editar: '.$producto->name : 'Nuevo producto' }}</h5>
    </div>
</div>

<form action="{{ isset($producto) ? route('admin.productos.update', $producto) : route('admin.productos.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($producto)) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card p-4">
                <h6 class="fw-600 mb-3">Información del producto</h6>
                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $producto->name ?? '') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $producto->description ?? '') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Categoría *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Seleccioná una categoría</option>
                            @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $producto->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control"
                               value="{{ old('sku', $producto->sku ?? '') }}" placeholder="CEL-0001">
                    </div>
                </div>
            </div>

            <div class="admin-card p-4 mt-3">
                <h6 class="fw-600 mb-3">Precios y stock</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Precio *</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="price" step="0.01" min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $producto->price ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Precio de oferta</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="sale_price" step="0.01" min="0"
                                   class="form-control"
                                   value="{{ old('sale_price', $producto->sale_price ?? '') }}"
                                   placeholder="Vacío = sin oferta">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stock *</label>
                        <input type="number" name="stock" min="0"
                               class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', $producto->stock ?? 0) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card p-4">
                <h6 class="fw-600 mb-3">Imagen principal</h6>
                @if(isset($producto) && $producto->images->where('is_main',true)->first())
                <img src="{{ $producto->images->where('is_main',true)->first()->url }}"
                     class="w-100 rounded-3 mb-3" style="height:180px;object-fit:cover">
                @endif
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <small class="text-muted">JPG, PNG o WebP. Máx 2MB.</small>
            </div>

            <div class="admin-card p-4 mt-3">
                <h6 class="fw-600 mb-3">Opciones</h6>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="chkActivo"
                           {{ old('is_active', $producto->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="chkActivo">Producto activo</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="featured" value="1" id="chkFeatured"
                           {{ old('featured', $producto->featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="chkFeatured">Destacado en la tienda</label>
                </div>
            </div>

            <div class="mt-3 d-grid gap-2">
                <button type="submit" class="btn btn-red py-2">
                    <i class="bi bi-check-lg me-1"></i>
                    {{ isset($producto) ? 'Guardar cambios' : 'Crear producto' }}
                </button>
                <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </div>
</form>
@endsection