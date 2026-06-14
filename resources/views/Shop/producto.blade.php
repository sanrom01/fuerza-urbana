@extends('layouts.app')
@section('title', $producto->name)

@section('content')
<div class="container py-5">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-danger text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/Catalogos-de-productos" class="text-danger text-decoration-none">Catálogo</a></li>
            <li class="breadcrumb-item">
                <a href="/Catalogos-de-productos?categoria={{ $producto->category->slug }}"
                   class="text-danger text-decoration-none">{{ $producto->category->name }}</a>
            </li>
            <li class="breadcrumb-item active text-white">{{ $producto->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">

        {{-- IMAGEN --}}
        <div class="col-lg-6">
            <div class="rounded-3 overflow-hidden" style="height:420px;background:#111">
                <img id="imgPrincipal"
                     src="{{ $producto->images->where('is_main',true)->first()?->url }}"
                     alt="{{ $producto->name }}"
                     class="w-100 h-100" style="object-fit:cover"
                     onerror="this.src='https://picsum.photos/seed/{{ $producto->id }}/600/600'">
            </div>
        </div>

        {{-- INFO --}}
        <div class="col-lg-6 text-white">
            <span class="badge bg-danger mb-2 text-uppercase">{{ $producto->category->name }}</span>
            <h1 class="fw-bold fs-2 mb-3">{{ $producto->name }}</h1>

            <div class="mb-3">
                @if($producto->sale_price)
                    <span class="fs-1 fw-bold text-danger">${{ number_format($producto->sale_price,0,',','.') }}</span>
                    <span class="text-muted text-decoration-line-through ms-2 fs-5">${{ number_format($producto->price,0,',','.') }}</span>
                @else
                    <span class="fs-1 fw-bold">${{ number_format($producto->price,0,',','.') }}</span>
                @endif
                <div class="text-muted small mt-1">
                    6 cuotas de ${{ number_format(($producto->sale_price ?? $producto->price)/6,0,',','.') }} sin interés
                </div>
            </div>

            @if($producto->stock > 0)
                <p class="text-success mb-3"><i class="bi bi-check-circle-fill me-1"></i>En stock — ¡Llevalo hoy!</p>
            @else
                <p class="text-danger mb-3"><i class="bi bi-x-circle-fill me-1"></i>Sin stock</p>
            @endif

            @if($producto->description)
            <p class="text-secondary mb-3">{{ $producto->description }}</p>
            @endif

            @if($producto->stock > 0)

            {{-- ── TALLE ── --}}
            <div class="mb-4">
                <p class="small fw-bold text-uppercase mb-2">
                    TALLE <span id="talleTexto" class="text-danger fw-bold"></span>
                </p>
                <div id="contenedorTalles" style="display:flex;gap:10px;flex-wrap:wrap">
                    @foreach(['XS','S','M','L','XL','XXL'] as $t)
                    <div id="talle-{{ $t }}"
                         style="
                            padding:10px 18px;
                            border:2px solid #555;
                            border-radius:8px;
                            color:#fff;
                            font-weight:700;
                            font-size:14px;
                            cursor:pointer;
                            user-select:none;
                            transition:all .15s;
                         "
                         onmouseover="if(talleElegido!='{{ $t }}')this.style.borderColor='#dc3545'"
                         onmouseout="if(talleElegido!='{{ $t }}')this.style.borderColor='#555'"
                         onclick="elegirTalle('{{ $t }}')">
                        {{ $t }}
                    </div>
                    @endforeach
                </div>
                <small id="avisoTalle" style="color:#dc3545;display:none;margin-top:6px;display:none">
                    ⚠ Seleccioná un talle antes de continuar.
                </small>
            </div>

            {{-- ── CANTIDAD ── --}}
            <div class="mb-4">
                <p class="small fw-bold text-uppercase mb-2">CANTIDAD</p>
                <div style="display:flex;align-items:center;gap:12px">
                    <button type="button"
                            style="background:#222;border:1px solid #555;color:#fff;padding:8px 16px;border-radius:8px;cursor:pointer;font-size:18px"
                            onclick="if(cantidadActual>1){cantidadActual--;document.getElementById('cantidadMostrar').textContent=cantidadActual}">
                        −
                    </button>
                    <span id="cantidadMostrar" style="font-size:20px;font-weight:700;min-width:30px;text-align:center">1</span>
                    <button type="button"
                            style="background:#222;border:1px solid #555;color:#fff;padding:8px 16px;border-radius:8px;cursor:pointer;font-size:18px"
                            onclick="if(cantidadActual<{{ $producto->stock }}){cantidadActual++;document.getElementById('cantidadMostrar').textContent=cantidadActual}">
                        +
                    </button>
                </div>
            </div>

            {{-- ── BOTÓN ── --}}
            @auth
            <button type="button" id="btnAgregar"
                    style="
                        background:#dc3545;
                        border:none;
                        color:#fff;
                        font-weight:700;
                        font-size:16px;
                        padding:16px;
                        width:100%;
                        border-radius:50px;
                        letter-spacing:1px;
                        cursor:pointer;
                        margin-bottom:20px;
                        transition:.2s;
                    "
                    onmouseover="this.style.background='#b02a37'"
                    onmouseout="this.style.background='#dc3545'"
                    onclick="agregarAlCarrito({{ $producto->id }})">
                🛒 AGREGAR AL CARRITO
            </button>
            @else
            <a href="/Login"
               style="display:block;background:#dc3545;color:#fff;font-weight:700;font-size:16px;padding:16px;width:100%;border-radius:50px;letter-spacing:1px;text-align:center;text-decoration:none;margin-bottom:20px">
                👤 INICIÁ SESIÓN PARA COMPRAR
            </a>
            @endauth

            @endif

            {{-- BENEFICIOS --}}
            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <div style="flex:1;min-width:100px;background:#111;padding:12px;border-radius:10px;text-align:center">
                    <div style="font-size:20px">🚚</div>
                    <small style="color:#888;font-size:11px">Envío a todo el país</small>
                </div>
                <div style="flex:1;min-width:100px;background:#111;padding:12px;border-radius:10px;text-align:center">
                    <div style="font-size:20px">🔒</div>
                    <small style="color:#888;font-size:11px">Compra segura</small>
                </div>
                <div style="flex:1;min-width:100px;background:#111;padding:12px;border-radius:10px;text-align:center">
                    <div style="font-size:20px">🔄</div>
                    <small style="color:#888;font-size:11px">30 días de cambio</small>
                </div>
            </div>
        </div>
    </div>

    {{-- RELACIONADOS --}}
    @if($relacionados->count())
    <div class="mt-5 pt-4 border-top border-secondary">
        <h4 class="fw-bold text-white mb-4">También te puede interesar</h4>
        <div class="row g-3">
            @foreach($relacionados as $rel)
            <div class="col-6 col-md-3">
                <a href="{{ route('productos.show', $rel->slug) }}" class="text-decoration-none">
                    <div class="card bg-dark border-secondary h-100">
                        <img src="{{ $rel->images->where('is_main',true)->first()?->url }}"
                             class="card-img-top" style="height:180px;object-fit:cover"
                             onerror="this.src='https://picsum.photos/seed/{{ $rel->id }}/300/300'">
                        <div class="card-body p-2">
                            <p class="text-white small fw-bold mb-1">{{ $rel->name }}</p>
                            <p class="text-danger fw-bold mb-0">${{ number_format($rel->sale_price ?? $rel->price,0,',','.') }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- MODAL --}}
<div id="modalCarrito" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:9999;align-items:center;justify-content:center">
    <div style="background:#1a1a1a;border:1px solid #444;border-radius:16px;padding:40px;max-width:440px;width:90%;text-align:center;color:#fff">
        <div style="font-size:56px;margin-bottom:12px">✅</div>
        <h4 style="font-weight:700;margin-bottom:4px">¡Producto agregado!</h4>
        <p style="color:#888;margin-bottom:4px">{{ $producto->name }}</p>
        <p style="color:#aaa;font-size:13px;margin-bottom:24px">
            Talle: <strong id="modalTalleTexto" style="color:#fff"></strong>
        </p>
        <hr style="border-color:#333;margin-bottom:24px">
        <p style="font-weight:700;margin-bottom:16px">¿Qué querés hacer?</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <a href="/Catalogos-de-productos"
               style="background:transparent;border:2px solid #fff;color:#fff;padding:12px 24px;border-radius:50px;font-weight:700;text-decoration:none">
                ← Seguir comprando
            </a>
            <a href="{{ route('checkout.index') }}"
               style="background:#dc3545;border:none;color:#fff;padding:12px 24px;border-radius:50px;font-weight:700;text-decoration:none">
                🔒 Finalizar compra
            </a>
        </div>
    </div>
</div>

<script>
var talleElegido   = null;
var cantidadActual = 1;

function elegirTalle(talle) {
    // Resetear todos
    ['XS','S','M','L','XL','XXL'].forEach(function(t) {
        var el = document.getElementById('talle-' + t);
        if (el) {
            el.style.borderColor = '#555';
            el.style.background  = 'transparent';
        }
    });
    // Marcar seleccionado
    var sel = document.getElementById('talle-' + talle);
    if (sel) {
        sel.style.borderColor = '#dc3545';
        sel.style.background  = '#dc3545';
    }
    talleElegido = talle;
    document.getElementById('talleTexto').textContent = '— ' + talle;
    document.getElementById('avisoTalle').style.display = 'none';
}

function agregarAlCarrito(productoId) {
    if (!talleElegido) {
        var aviso = document.getElementById('avisoTalle');
        aviso.style.display = 'block';
        document.getElementById('contenedorTalles').scrollIntoView({ behavior:'smooth', block:'center' });
        return;
    }

    var btn = document.getElementById('btnAgregar');
    btn.disabled = true;
    btn.textContent = 'Agregando...';

    var csrf = document.querySelector('meta[name="csrf-token"]');
    if (!csrf) {
        alert('Error de configuración: falta el meta csrf-token en el layout.');
        btn.disabled = false;
        btn.textContent = '🛒 AGREGAR AL CARRITO';
        return;
    }

    fetch('/productos/' + productoId + '/carrito', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf.content
        },
        body: JSON.stringify({
            cantidad: cantidadActual,
            talle:    talleElegido
        })
    })
    .then(function(res) {
        if (!res.ok) {
            return res.text().then(function(txt) {
                throw new Error('Error ' + res.status + ': ' + txt.substring(0, 200));
            });
        }
        return res.json();
    })
    .then(function(data) {
        btn.disabled = false;
        btn.textContent = '🛒 AGREGAR AL CARRITO';
        document.getElementById('modalTalleTexto').textContent = talleElegido;
        document.getElementById('modalCarrito').style.display = 'flex';
    })
    .catch(function(err) {
        btn.disabled = false;
        btn.textContent = '🛒 AGREGAR AL CARRITO';
        alert('Error al agregar: ' + err.message);
    });
}

// Cerrar modal al hacer click fuera
document.getElementById('modalCarrito').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endsection