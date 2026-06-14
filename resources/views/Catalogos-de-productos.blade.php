@extends('layouts.app')
@section('title', 'Catálogo')

@section('content')

<section class="hero text-center d-flex align-items-center">
    <div class="container">
        <h1 class="fw-bold" style="font-size:clamp(1.5rem,5vw,3rem)">Catálogo Deportivo</h1>
        <p class="lead">Equipate con lo mejor en rendimiento y estilo</p>
    </div>
</section>

<section class="container mt-4 mb-5" id="productos">

    {{-- ── FILTROS MÓVIL ────────────────────────────────── --}}
    <div class="d-lg-none mb-3">
        <button onclick="toggleFiltros()"
                style="width:100%;background:#1a1a1a;border:1px solid #333;color:#fff;padding:12px;border-radius:10px;font-weight:700;font-size:.9rem;cursor:pointer">
            <i class="bi bi-sliders me-2 text-danger"></i>Filtros y categorías
            <i class="bi bi-chevron-down ms-2" id="iconFiltro"></i>
        </button>

        <div id="panelFiltrosMobile" style="display:none;background:#1a1a1a;border-radius:0 0 10px 10px;padding:16px;border:1px solid #333;border-top:none">
            {{-- Categorías como chips --}}
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
                <a href="/Catalogos-de-productos"
                   style="padding:6px 14px;border-radius:20px;font-size:.85rem;font-weight:700;text-decoration:none;{{ !request('categoria') ? 'background:#dc3545;color:#fff' : 'background:#333;color:#aaa' }}">
                    Todos
                </a>
                @foreach($categorias as $cat)
                <a href="/Catalogos-de-productos?categoria={{ $cat->slug }}"
                   style="padding:6px 14px;border-radius:20px;font-size:.85rem;font-weight:700;text-decoration:none;{{ request('categoria')==$cat->slug ? 'background:#dc3545;color:#fff' : 'background:#333;color:#aaa' }}">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>

            <form method="GET" action="/Catalogos-de-productos" id="formFiltrosMobile">
                @if(request('categoria'))
                <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                @endif
                <div style="margin-bottom:12px">
                    <label style="font-size:.8rem;color:#aaa;font-weight:600;text-transform:uppercase">Precio máximo</label>
                    <input type="range" class="form-range mt-1" name="precio_max"
                           min="0" max="100000" step="500"
                           value="{{ request('precio_max', 100000) }}"
                           oninput="document.getElementById('precioValM').textContent='$'+Number(this.value).toLocaleString('es-AR')">
                    <small style="color:#888">Hasta: <span id="precioValM">${{ number_format(request('precio_max',100000),0,',','.') }}</span></small>
                </div>
                <div style="margin-bottom:12px">
                    <label style="font-size:.8rem;color:#aaa;font-weight:600;text-transform:uppercase">Ordenar por</label>
                    <select name="orden" class="form-select form-select-sm mt-1"
                            style="background:#222;color:#fff;border-color:#555"
                            onchange="document.getElementById('formFiltrosMobile').submit()">
                        <option value="">Relevancia</option>
                        <option value="precio_asc"  {{ request('orden')=='precio_asc'  ?'selected':'' }}>Menor precio</option>
                        <option value="precio_desc" {{ request('orden')=='precio_desc' ?'selected':'' }}>Mayor precio</option>
                    </select>
                </div>
                <div style="display:flex;gap:8px">
                    <button type="submit"
                            style="flex:1;background:#dc3545;border:none;color:#fff;padding:10px;border-radius:8px;font-weight:700;cursor:pointer">
                        Aplicar
                    </button>
                    @if(request()->hasAny(['precio_max','orden','buscar','categoria']))
                    <a href="/Catalogos-de-productos"
                       style="flex:1;background:#333;color:#fff;padding:10px;border-radius:8px;font-weight:700;text-align:center;text-decoration:none;font-size:.9rem">
                        Limpiar
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- ── BUSCADOR (siempre visible) ──────────────────── --}}
    <form method="GET" action="/Catalogos-de-productos" class="d-flex gap-2 mb-4">
        @if(request('categoria'))
        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
        @endif
        <input type="text" name="buscar" value="{{ request('buscar') }}"
               class="form-control" placeholder="Buscar producto...">
        <button class="btn btn-danger px-3"><i class="bi bi-search"></i></button>
    </form>

    <div class="row g-4">

        {{-- ── SIDEBAR DESKTOP ──────────────────────────── --}}
        <aside class="col-lg-3 d-none d-lg-block">
            <div class="filtros shadow-sm rounded p-4">
                <h5 class="fw-bold mb-3">PRODUCTOS</h5>
                <ul class="lista-categorias mb-4">
                    <li>
                        <a href="/Catalogos-de-productos"
                           style="text-decoration:none;{{ !request('categoria') ? 'color:#dc3545;font-weight:700' : 'color:inherit' }}">
                            Todos
                        </a>
                    </li>
                    @foreach($categorias as $cat)
                    <li>
                        <a href="/Catalogos-de-productos?categoria={{ $cat->slug }}"
                           style="text-decoration:none;{{ request('categoria')==$cat->slug ? 'color:#dc3545;font-weight:700' : 'color:inherit' }}">
                            {{ $cat->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <h6 class="fw-bold">Filtrar por</h6>
                <form method="GET" action="/Catalogos-de-productos" id="formFiltros">
                    @if(request('categoria'))
                    <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    @endif

                    <p class="mt-3 mb-1 fw-bold small">Precio máximo</p>
                    <input type="range" class="form-range" name="precio_max"
                           min="0" max="100000" step="500"
                           value="{{ request('precio_max', 100000) }}"
                           oninput="document.getElementById('precioVal').textContent='$'+Number(this.value).toLocaleString('es-AR')">
                    <small class="text-muted">Hasta: <span id="precioVal">${{ number_format(request('precio_max',100000),0,',','.') }}</span></small>

                    <p class="mt-3 mb-1 fw-bold small">Ordenar por</p>
                    <select name="orden" class="form-select form-select-sm mb-3"
                            onchange="document.getElementById('formFiltros').submit()">
                        <option value="">Relevancia</option>
                        <option value="precio_asc"  {{ request('orden')=='precio_asc'  ?'selected':'' }}>Menor precio</option>
                        <option value="precio_desc" {{ request('orden')=='precio_desc' ?'selected':'' }}>Mayor precio</option>
                    </select>

                    <button type="submit" class="btn btn-danger btn-sm w-100">Aplicar filtros</button>
                    @if(request()->hasAny(['precio_max','orden','buscar','categoria']))
                    <a href="/Catalogos-de-productos" class="btn btn-outline-secondary btn-sm w-100 mt-2">Limpiar</a>
                    @endif
                </form>
            </div>
        </aside>

        {{-- ── GRID DE PRODUCTOS (DESDE LA BD) ─────────── --}}
        <main class="col-12 col-lg-9">

            @if($productos->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-search" style="font-size:3rem;color:#555"></i>
                <h5 class="text-white mt-3">No se encontraron productos</h5>
                <a href="/Catalogos-de-productos" class="btn btn-danger mt-2">Ver todos</a>
            </div>
            @else
            <p class="text-muted small mb-3">{{ $productos->total() }} producto(s) encontrado(s)</p>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:16px">
                @foreach($productos as $producto)
                @php
                    $imagen = $producto->images->where('is_main', true)->first()?->url
                              ?? $producto->images->first()?->url
                              ?? null;
                    $precio = $producto->sale_price ?? $producto->price;
                @endphp
                <div class="producto shadow-sm rounded overflow-hidden">
                    <a href="/productos/{{ $producto->slug }}">
                        @if($imagen)
                        <img src="{{ $imagen }}" alt="{{ $producto->name }}"
                             style="width:100%;height:200px;object-fit:cover;display:block">
                        @else
                        <img src="https://picsum.photos/seed/{{ $producto->id }}/300/200"
                             alt="{{ $producto->name }}"
                             style="width:100%;height:200px;object-fit:cover;display:block">
                        @endif
                    </a>
                    <div class="p-2 text-center">
                        <h6 style="font-size:.82rem;margin-bottom:4px;font-weight:600">{{ $producto->name }}</h6>

                        @if($producto->sale_price)
                        <p class="precio" style="font-size:.95rem;margin-bottom:0">
                            ${{ number_format($producto->sale_price,0,',','.') }}
                        </p>
                        <small class="text-muted text-decoration-line-through">
                            ${{ number_format($producto->price,0,',','.') }}
                        </small>
                        @else
                        <p class="precio" style="font-size:.95rem;margin-bottom:2px">
                            ${{ number_format($producto->price,0,',','.') }}
                        </p>
                        @endif

                        <p class="cuotas" style="font-size:.72rem">6 cuotas sin interés</p>

                        @if($producto->stock > 0)
                        <a href="/productos/{{ $producto->slug }}"
                           class="btn btn-danger btn-sm w-100 rounded-pill" style="font-size:.8rem">
                            Comprar
                        </a>
                        @else
                        <button class="btn btn-secondary btn-sm w-100 rounded-pill" style="font-size:.8rem" disabled>
                            Sin stock
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            @if($productos->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $productos->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
            @endif
            @endif
        </main>
    </div>
</section>
@endsection

@push('styles')
<style>
.lista-categorias { list-style:none;padding:0 }
.lista-categorias li { padding:5px 0 }
</style>
@endpush

@push('scripts')
<script>
function toggleFiltros() {
    var panel = document.getElementById('panelFiltrosMobile');
    var icon  = document.getElementById('iconFiltro');
    if (panel.style.display === 'none') {
        panel.style.display = 'block';
        icon.className = 'bi bi-chevron-up ms-2';
    } else {
        panel.style.display = 'none';
        icon.className = 'bi bi-chevron-down ms-2';
    }
}
</script>
@endpush