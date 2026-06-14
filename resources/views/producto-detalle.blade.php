@extends('layouts.app')
@section('title', request('nombre', 'Producto'))

@section('content')

@php
$nombre  = request('nombre', 'Producto');
$precio  = (int) request('precio', 0);
$img     = request('img', 'remera.jpeg');
$cat     = request('cat', 'remeras');
$slug    = \Illuminate\Support\Str::slug($nombre);

// Calcular cuota
$cuota = number_format($precio / 6, 0, ',', '.');
$precioFmt = number_format($precio, 0, ',', '.');
@endphp

<div class="container py-5">

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/Principal" class="text-danger text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/Catalogos-de-productos" class="text-danger text-decoration-none">Catálogo</a></li>
            <li class="breadcrumb-item"><a href="/Catalogos-de-productos?categoria={{ $cat }}" class="text-danger text-decoration-none">{{ ucfirst($cat) }}</a></li>
            <li class="breadcrumb-item active text-white">{{ $nombre }}</li>
        </ol>
    </nav>

    <div class="row g-5 align-items-start">

        {{-- IMAGEN --}}
        <div class="col-lg-6">
            <div class="rounded-3 overflow-hidden" style="background:#111">
                <img src="{{ asset('img/catalogo/'.$img) }}"
                     alt="{{ $nombre }}"
                     class="w-100" style="height:460px;object-fit:cover">
            </div>
        </div>

        {{-- INFO --}}
        <div class="col-lg-6 text-white">
            <span class="badge bg-danger mb-3 text-uppercase">{{ $cat }}</span>
            <h1 class="fw-bold fs-2 mb-3">{{ $nombre }}</h1>

            {{-- PRECIO --}}
            <div class="mb-4">
                <div class="fs-1 fw-bold text-danger">${{ $precioFmt }}</div>
                <div class="text-muted">6 cuotas de ${{ $cuota }} sin interés</div>
            </div>

            {{-- STOCK --}}
            <p class="text-success mb-3">
                <i class="bi bi-check-circle-fill me-1"></i> En stock — ¡Llevalo hoy!
            </p>

            {{-- TALLE --}}
            <div class="mb-4">
                <label class="fw-bold text-white small text-uppercase mb-2 d-block">Talle</label>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach(['XS','S','M','L','XL','XXL'] as $talle)
                    <label class="border border-secondary rounded-2 px-3 py-2 text-white"
                           style="cursor:pointer;font-size:.85rem;transition:.15s"
                           onmouseover="this.style.borderColor='#dc3545'"
                           onmouseout="if(!this.querySelector('input').checked)this.style.borderColor='#6c757d'">
                        <input type="radio" name="talle" value="{{ $talle }}"
                               class="d-none"
                               onchange="document.querySelectorAll('[name=talle]').forEach(r=>r.parentElement.style.borderColor='#6c757d');this.parentElement.style.borderColor='#dc3545'">
                        {{ $talle }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- CANTIDAD --}}
            <div class="mb-4">
                <label class="fw-bold text-white small text-uppercase mb-2 d-block">Cantidad</label>
                <div class="input-group" style="width:140px">
                    <button class="btn btn-outline-secondary" type="button"
                            onclick="let i=document.getElementById('qty');if(i.value>1)i.value--">
                        <i class="bi bi-dash"></i>
                    </button>
                    <input type="number" id="qty" value="1" min="1" max="10"
                           class="form-control text-center bg-black text-white border-secondary">
                    <button class="btn btn-outline-secondary" type="button"
                            onclick="let i=document.getElementById('qty');if(i.value<10)i.value++">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
            </div>

            {{-- BOTÓN AGREGAR AL CARRITO --}}
            @auth
            <div class="d-flex gap-3 mb-4">
                <button onclick="agregarAlCarrito()"
                        class="btn btn-danger btn-lg flex-grow-1 fw-bold rounded-pill">
                    <i class="bi bi-cart-plus me-2"></i>AGREGAR AL CARRITO
                </button>
            </div>
            @else
            <div class="d-flex gap-3 mb-4">
                <a href="/Login" class="btn btn-danger btn-lg flex-grow-1 fw-bold rounded-pill">
                    <i class="bi bi-person me-2"></i>INICIÁ SESIÓN PARA COMPRAR
                </a>
            </div>
            @endauth

            {{-- BENEFICIOS --}}
            <div class="row g-2 text-center mt-2">
                <div class="col-4">
                    <div class="p-2 rounded-3" style="background:#1a1a1a">
                        <i class="bi bi-truck text-danger d-block mb-1"></i>
                        <small class="text-muted" style="font-size:.72rem">Envío a todo el país</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 rounded-3" style="background:#1a1a1a">
                        <i class="bi bi-shield-check text-danger d-block mb-1"></i>
                        <small class="text-muted" style="font-size:.72rem">Compra segura</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 rounded-3" style="background:#1a1a1a">
                        <i class="bi bi-arrow-repeat text-danger d-block mb-1"></i>
                        <small class="text-muted" style="font-size:.72rem">30 días de cambio</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Producto agregado --}}
<div class="modal fade" id="modalCarrito" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white">
            <div class="modal-body text-center p-4">
                <i class="bi bi-cart-check-fill text-success fs-1 mb-3 d-block"></i>
                <h5 class="fw-bold mb-1">¡Producto agregado!</h5>
                <p class="text-secondary mb-4">{{ $nombre }} está en tu carrito.</p>
                <div class="d-flex gap-3 justify-content-center">
                    <button class="btn btn-outline-light" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-1"></i>Seguir comprando
                    </button>
                    <a href="/Carrito" class="btn btn-danger fw-bold">
                        <i class="bi bi-cart3 me-1"></i>Finalizar compra
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script>
function agregarAlCarrito() {
    const cantidad = document.getElementById('qty').value;

    fetch('/carrito/agregar-estatico', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            nombre:   '{{ $nombre }}',
            precio:   {{ $precio }},
            imagen:   '{{ asset("img/catalogo/".$img) }}',
            cantidad: parseInt(cantidad),
        })
    })
    .then(res => res.json())
    .then(() => {
        new bootstrap.Modal(document.getElementById('modalCarrito')).show();
    })
    .catch(() => {
        window.location.href = '/Login';
    });
}
</script>
@endpush
