@extends('layouts.admin')
@section('title', 'Producto: '.$producto->name)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.productos.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">{{ $producto->name }}</h5>
    @if($producto->is_active)
        <span class="badge bg-success">Activo</span>
    @else
        <span class="badge bg-secondary">Inactivo</span>
    @endif
    @if($producto->featured)
        <span class="badge bg-warning text-dark">Destacado</span>
    @endif
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="admin-card overflow-hidden mb-3">
            @php $imgPrincipal = $producto->images->where('is_main', true)->first() @endphp
            <img src="{{ $imgPrincipal?->url ?? 'https://picsum.photos/seed/'.$producto->id.'/600/400' }}"
                 alt="{{ $producto->name }}" class="w-100" style="height:300px;object-fit:cover">
        </div>
        @if($producto->images->count() > 1)
        <div class="admin-card p-3">
            <h6 class="fw-600 mb-3 small text-uppercase text-muted">Más imágenes</h6>
            <div class="d-flex gap-2 flex-wrap">
                @foreach($producto->images as $img)
                <img src="{{ $img->url }}" alt=""
                     style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:2px solid {{ $img->is_main ? '#e63946' : '#eee' }}">
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-7">
        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3">Información general</h6>
            <table class="table table-sm mb-0">
                <tr><td class="text-muted" style="width:140px">Categoría</td>
                    <td><span class="badge bg-light text-dark border">{{ $producto->category->name }}</span></td></tr>
                <tr><td class="text-muted">SKU</td><td><code>{{ $producto->sku ?? '—' }}</code></td></tr>
                <tr><td class="text-muted">Descripción</td><td>{{ $producto->description ?? '—' }}</td></tr>
                <tr><td class="text-muted">Creado</td><td class="small">{{ $producto->created_at->format('d/m/Y H:i') }}</td></tr>
                <tr><td class="text-muted">Actualizado</td><td class="small">{{ $producto->updated_at->format('d/m/Y H:i') }}</td></tr>
            </table>
        </div>

        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3">Precios y stock</h6>
            <div class="row g-3 text-center">
                <div class="col-4">
                    <div class="p-3 rounded-3" style="background:#f8f7fd">
                        <div class="fw-700 fs-4">${{ number_format($producto->price, 0, ',', '.') }}</div>
                        <small class="text-muted">Precio</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 rounded-3" style="background:{{ $producto->sale_price ? '#fff0f0' : '#f8f7fd' }}">
                        <div class="fw-700 fs-4 {{ $producto->sale_price ? 'text-danger' : 'text-muted' }}">
                            {{ $producto->sale_price ? '$'.number_format($producto->sale_price,0,',','.') : '—' }}
                        </div>
                        <small class="text-muted">Precio oferta</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 rounded-3" style="background:{{ $producto->stock == 0 ? '#fff0f0' : '#f0fff4' }}">
                        <div class="fw-700 fs-4 {{ $producto->stock == 0 ? 'text-danger' : 'text-success' }}">
                            {{ $producto->stock }}
                        </div>
                        <small class="text-muted">Stock (mín. {{ $producto->stock_min }})</small>
                    </div>
                </div>
            </div>
        </div>

        @if($producto->reviews->count())
        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3">Reseñas ({{ $producto->reviews->count() }})</h6>
            @foreach($producto->reviews->take(3) as $r)
            <div class="d-flex gap-3 mb-2 pb-2 border-bottom">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <span class="fw-500 small">{{ $r->user->name }}</span>
                        <div>@for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$r->rating?'-fill text-warning':' text-muted' }}" style="font-size:.7rem"></i>@endfor</div>
                    </div>
                    <p class="text-muted small mb-0">{{ $r->comment }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="d-flex gap-2">
            <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-red px-4">
                <i class="bi bi-pencil me-2"></i>Editar producto
            </a>
            <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar este producto?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger"><i class="bi bi-trash3 me-2"></i>Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection