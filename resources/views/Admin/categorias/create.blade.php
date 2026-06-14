@extends('layouts.admin')
@section('title', 'Nueva categoría')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.categorias.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">Nueva categoría</h5>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-card p-4">

            @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf

                {{-- TIPO --}}
                <div class="mb-3">
                    <label class="form-label">Tipo *</label>
                    <div class="d-flex gap-3">
                        <label class="d-flex align-items-center gap-2 p-3 rounded-3 border flex-grow-1"
                               style="cursor:pointer" id="labelPadre">
                            <input type="radio" name="tipo" value="padre" id="tipoPadre"
                                   {{ old('tipo','padre')=='padre' ? 'checked':'' }}
                                   onchange="togglePadre(this)">
                            <div>
                                <div class="fw-600">Categoría padre</div>
                                <small class="text-muted">Ej: Remeras, Buzos, Zapatillas</small>
                            </div>
                        </label>
                        <label class="d-flex align-items-center gap-2 p-3 rounded-3 border flex-grow-1"
                               style="cursor:pointer" id="labelHija">
                            <input type="radio" name="tipo" value="hija" id="tipoHija"
                                   {{ old('tipo')=='hija' ? 'checked':'' }}
                                   onchange="togglePadre(this)">
                            <div>
                                <div class="fw-600">Subcategoría</div>
                                <small class="text-muted">Ej: Remeras de Hombre, Buzos de Fútbol</small>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- CATEGORÍA PADRE (solo si es subcategoría) --}}
                <div id="selectPadre" class="mb-3" style="{{ old('tipo')=='hija' ? '' : 'display:none' }}">
                    <label class="form-label">Categoría padre *</label>
                    <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">— Seleccioná la categoría padre —</option>
                        @foreach($padres as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected':'' }}>
                            {{ $p->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('parent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- NOMBRE --}}
                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Ej: Remeras, Shorts de fútbol..."
                           required autofocus>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="3" class="form-control"
                              placeholder="Descripción breve (opcional)">{{ old('description') }}</textarea>
                </div>

                {{-- ORDEN --}}
                <div class="mb-3">
                    <label class="form-label">Orden de aparición</label>
                    <input type="number" name="sort_order" min="0"
                           class="form-control" value="{{ old('sort_order', 0) }}"
                           style="width:120px">
                    <small class="text-muted">Menor número = aparece primero</small>
                </div>

                {{-- ESTADO --}}
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                               name="is_active" value="1" id="chkActivo"
                               {{ old('is_active', true) ? 'checked':'' }}>
                        <label class="form-check-label" for="chkActivo">
                            Categoría activa (visible en la tienda)
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-red px-4">
                        <i class="bi bi-check-lg me-1"></i>Crear categoría
                    </button>
                    <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePadre(radio) {
    var sel = document.getElementById('selectPadre');
    sel.style.display = radio.value === 'hija' ? 'block' : 'none';
}
// Marcar borde del seleccionado
document.querySelectorAll('input[name="tipo"]').forEach(function(r) {
    r.addEventListener('change', function() {
        document.getElementById('labelPadre').style.borderColor = '#dee2e6';
        document.getElementById('labelHija').style.borderColor  = '#dee2e6';
        document.getElementById(this.value === 'padre' ? 'labelPadre' : 'labelHija').style.borderColor = '#e63946';
    });
});
// Inicializar
var checked = document.querySelector('input[name="tipo"]:checked');
if (checked) {
    document.getElementById(checked.value === 'padre' ? 'labelPadre' : 'labelHija').style.borderColor = '#e63946';
}
</script>
@endpush