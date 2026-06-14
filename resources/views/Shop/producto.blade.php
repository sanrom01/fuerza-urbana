@extends('layouts.app')
@section('title', $producto->name)

@section('content')
<div class="container py-5">

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-danger">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/Catalogos-de-productos" class="text-decoration-none text-danger">Productos</a></li>
            <li class="breadcrumb-item active text-white">{{ $producto->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">

        {{-- GALERÍA --}}
        <div class="col-lg-6">
            <div class="rounded-3 overflow-hidden bg-dark border border-secondary" style="height:420px">
                <img id="imgPrincipal"
                     src="{{ $producto->images->where('is_main',true)->first()?->url ?? 'https://picsum.photos/seed/'.$producto->id.'/600/600' }}"
                     alt="{{ $producto->name }}"
                     class="w-100 h-100" style="object-fit:cover">
            </div>
            @if($producto->images->count() > 1)
            <div class="d-flex gap-2 mt-3">
                @foreach($producto->images as $img)
                <img src="{{ $img->url }}" alt=""
                     onclick="document.getElementById('imgPrincipal').src=this.src"
                     class="rounded-2 border border-secondary"
                     style="width:68px;height:68px;object-fit:cover;cursor:pointer">
                @endforeach
            </div>
            @endif
        </div>

        {{-- INFO --}}
        <div class="col-lg-6 text-white">
            <span class="badge bg-danger mb-2">{{ $producto->category->name }}</span>
            <h1 class="fw-bold fs-2 mb-3">{{ $producto->name }}</h1>

            {{-- PRECIO --}}
            <div class="mb-4">
                @if($producto->sale_price)
                    <span class="fs-1 fw-bold text-danger">
                        ${{ number_format($producto->sale_price, 0, ',', '.') }}
                    </span>
                    <span class="text-muted text-decoration-line-through ms-2 fs-5">
                        ${{ number_format($producto->price, 0, ',', '.') }}
                    </span>
                    <span class="badge bg-danger ms-2">
                        -{{ round((1 - $producto->sale_price / $producto->price) * 100) }}% OFF
                    </span>
                @else
                    <span class="fs-1 fw-bold">
                        ${{ number_format($producto->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            {{-- STOCK --}}
            @if($producto->stock > 0)
                <p class="text-success mb-3">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    En stock ({{ $producto->stock }} disponibles)
                </p>
            @else
                <p class="text-danger mb-3">
                    <i class="bi bi-x-circle-fill me-1"></i>Sin stock disponible
                </p>
            @endif

            {{-- DESCRIPCIÓN --}}
            <p class="text-secondary lh-lg mb-4">{{ $producto->description }}</p>

            @if($producto->sku)
            <p class="text-muted small mb-4">SKU: {{ $producto->sku }}</p>
            @endif

            {{-- AGREGAR AL CARRITO --}}
            @if($producto->stock > 0)
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="input-group" style="width:130px">
                    <button class="btn btn-outline-secondary" type="button"
                            onclick="let i=document.getElementById('qty');if(i.value>1)i.value--">
                        <i class="bi bi-dash"></i>
                    </button>
                    <input type="number" id="qty" value="1" min="1"
                           max="{{ $producto->stock }}"
                           class="form-control text-center bg-black text-white border-secondary">
                    <button class="btn btn-outline-secondary" type="button"
                            onclick="let i=document.getElementById('qty');if(i.value<{{ $producto->stock }})i.value++">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                <button onclick="agregarAlCarrito({{ $producto->id }})"
                        class="btn btn-danger btn-lg flex-grow-1 fw-bold">
                    <i class="bi bi-cart-plus me-2"></i>AGREGAR AL CARRITO
                </button>
            </div>
            @endif

            {{-- INFO EXTRA --}}
            <div class="d-flex gap-3 text-secondary small">
                <span><i class="bi bi-truck me-1"></i>Envío a todo el país</span>
                <span><i class="bi bi-shield-check me-1"></i>Compra segura</span>
                <span><i class="bi bi-arrow-repeat me-1"></i>30 días de cambio</span>
            </div>
        </div>
    </div>

    {{-- RESEÑAS --}}
    @if($producto->reviews->where('is_approved', true)->count())
    <div class="mt-5 pt-4 border-top border-secondary">
        <h4 class="fw-bold text-white mb-4">Opiniones de clientes</h4>
        <div class="row g-3">
            @foreach($producto->reviews->where('is_approved', true) as $review)
            <div class="col-md-6">
                <div class="card bg-dark border-secondary p-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold text-white">{{ $review->user->name }}</span>
                        <span>
                            @for($i=1;$i<=5;$i++)
                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-secondary' }}"></i>
                            @endfor
                        </span>
                    </div>
                    @if($review->title)
                    <div class="fw-500 text-white mb-1">{{ $review->title }}</div>
                    @endif
                    <p class="text-secondary small mb-0">{{ $review->comment }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- RELACIONADOS --}}
    @if($relacionados->count())
    <div class="mt-5 pt-4 border-top border-secondary">
        <h4 class="fw-bold text-white mb-4">También te puede interesar</h4>
        <div class="row g-3">
            @foreach($relacionados as $rel)
            <div class="col-6 col-md-3">
                <a href="{{ route('productos.show', $rel->slug) }}" class="text-decoration-none">
                    <div class="card bg-dark border-secondary h-100">
                        <img src="{{ $rel->images->where('is_main',true)->first()?->url ?? 'https://picsum.photos/seed/'.$rel->id.'/300/300' }}"
                             class="card-img-top" style="height:180px;object-fit:cover">
                        <div class="card-body p-2">
                            <p class="text-white small fw-500 mb-1">{{ $rel->name }}</p>
                            <p class="text-danger fw-bold mb-0">
                                ${{ number_format($rel->sale_price ?? $rel->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- MODAL: Producto agregado al carrito --}}
<div class="modal fade" id="modalCarrito" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white">
            <div class="modal-body text-center p-4">
                <i class="bi bi-cart-check-fill text-success fs-1 mb-3 d-block"></i>
                <h5 class="fw-bold mb-1">¡Producto agregado!</h5>
                <p class="text-secondary mb-4">{{ $producto->name }} está en tu carrito.</p>
                <div class="d-flex gap-3 justify-content-center">
                    <button class="btn btn-outline-light" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-1"></i>Seguir comprando
                    </button>
                    <a href="{{ route('carrito.index') }}" class="btn btn-danger fw-bold">
                        <i class="bi bi-cart3 me-1"></i>Finalizar compra
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function agregarAlCarrito(productoId) {
    const cantidad = document.getElementById('qty').value;

    fetch(`/productos/${productoId}/carrito`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ cantidad: cantidad }),
    })
    .then(res => res.json())
    .then(data => {
        // Actualizar badge del carrito en navbar
        const badge = document.querySelector('.cart-badge-count');
        if (badge) badge.textContent = data.cantidad;

        // Mostrar modal
        new bootstrap.Modal(document.getElementById('modalCarrito')).show();
    })
    .catch(() => {
        window.location.href = '/Login';
    });
}
</script>
@endpush
