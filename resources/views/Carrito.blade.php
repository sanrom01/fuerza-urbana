@extends('layouts.app')
@section('title', 'Mi Carrito')

@section('content')
<div class="container text-white" style="padding-top:80px;padding-bottom:60px">

    <h2 class="fw-bold text-uppercase mb-4" style="letter-spacing:2px;font-size:clamp(1.3rem,4vw,2rem)">
        <i class="bi bi-cart3 me-2 text-danger"></i>TU CARRITO
    </h2>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(empty($carrito))
    <div class="text-center py-5">
        <i class="bi bi-cart-x" style="font-size:4rem;color:#444"></i>
        <h4 class="mt-3 text-secondary">Tu carrito está vacío</h4>
        <p class="text-muted">Explorá el catálogo y agregá productos.</p>
        <a href="/Catalogos-de-productos" class="btn btn-danger rounded-pill px-4 mt-2">
            <i class="bi bi-bag me-2"></i>Ir al catálogo
        </a>
    </div>

    @else

    {{-- En móvil: columna única. En desktop: dos columnas --}}
    <div class="row g-4">

        {{-- ── PRODUCTOS ─────────────────────────────── --}}
        <div class="col-12 col-lg-8">
            <div style="background:#1a1a1a;border-radius:16px;overflow:hidden">
                @foreach($carrito as $key => $item)
                <div style="padding:16px 20px;{{ !$loop->last ? 'border-bottom:1px solid #2a2a2a' : '' }}">

                    {{-- Fila superior: imagen + info + eliminar --}}
                    <div style="display:flex;gap:14px;align-items:flex-start">

                        {{-- Imagen --}}
                        <img src="{{ $item['imagen'] }}"
                             alt="{{ $item['nombre'] }}"
                             style="width:72px;height:72px;object-fit:cover;border-radius:10px;flex-shrink:0"
                             onerror="this.src='https://picsum.photos/seed/{{ $loop->index }}/72/72'">

                        {{-- Info central --}}
                        <div style="flex:1;min-width:0">
                            <div style="font-weight:700;font-size:.95rem;margin-bottom:4px" class="text-truncate">
                                {{ $item['nombre'] }}
                            </div>
                            <span style="background:#444;color:#fff;font-size:.7rem;padding:2px 8px;border-radius:10px;margin-bottom:6px;display:inline-block">
                                Talle: {{ $item['talle'] ?? 'Único' }}
                            </span>
                            <div style="color:#dc3545;font-weight:700;font-size:1rem">
                                ${{ number_format($item['precio'], 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Eliminar (esquina derecha) --}}
                        <form action="{{ route('carrito.eliminar', $key) }}" method="POST">
                            @csrf @method('DELETE')
                            <button style="background:transparent;border:1px solid #dc3545;color:#dc3545;padding:6px 12px;border-radius:20px;font-size:.8rem;cursor:pointer;white-space:nowrap">
                                <i class="bi bi-trash3 me-1"></i>Eliminar
                            </button>
                        </form>
                    </div>

                    {{-- Fila inferior: cantidad + subtotal --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:12px;padding-top:10px;border-top:1px solid #2a2a2a">
                        <div style="display:flex;align-items:center;gap:8px">
                            <form action="{{ route('carrito.actualizar', $key) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="accion" value="restar">
                                <button style="background:#222;border:1px solid #555;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:16px"
                                        {{ $item['cantidad'] <= 1 ? 'disabled' : '' }}>−</button>
                            </form>
                            <span style="font-weight:700;font-size:1.1rem;min-width:24px;text-align:center">
                                {{ $item['cantidad'] }}
                            </span>
                            <form action="{{ route('carrito.actualizar', $key) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="accion" value="sumar">
                                <button style="background:#222;border:1px solid #555;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:16px">+</button>
                            </form>
                        </div>
                        <div style="color:#aaa;font-size:.85rem">
                            Subtotal: <strong style="color:#fff">${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Botones inferiores --}}
            <div class="d-flex gap-2 mt-3 flex-wrap">
                <a href="/Catalogos-de-productos"
                   style="flex:1;min-width:140px;background:transparent;border:2px solid #fff;color:#fff;padding:10px 16px;border-radius:50px;font-weight:700;text-align:center;text-decoration:none;font-size:.85rem">
                    ← Seguir comprando
                </a>
                <form action="{{ route('carrito.vaciar') }}" method="POST" style="flex:1;min-width:140px">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('¿Vaciar todo el carrito?')"
                            style="width:100%;background:transparent;border:2px solid #dc3545;color:#dc3545;padding:10px 16px;border-radius:50px;font-weight:700;font-size:.85rem;cursor:pointer">
                        🗑 Vaciar carrito
                    </button>
                </form>
            </div>
        </div>

        {{-- ── RESUMEN ────────────────────────────────── --}}
        <div class="col-12 col-lg-4">
            <div style="background:#1a1a1a;border-radius:16px;padding:24px">
                <h5 style="font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">
                    Resumen
                </h5>
                <hr style="border-color:#333">

                @foreach($carrito as $item)
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:.85rem">
                    <span style="color:#aaa;max-width:65%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                        {{ $item['nombre'] }} x{{ $item['cantidad'] }}
                    </span>
                    <span>${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</span>
                </div>
                @endforeach

                <hr style="border-color:#333">

                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:.9rem">
                    <span style="color:#aaa">Subtotal</span>
                    <span>${{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:16px;font-size:.9rem">
                    <span style="color:#aaa">Envío</span>
                    <span style="color:#28a745">A calcular</span>
                </div>

                <hr style="border-color:#333">

                <div style="display:flex;justify-content:space-between;font-weight:700;font-size:1.2rem;margin-bottom:20px">
                    <span>TOTAL</span>
                    <span style="color:#dc3545">${{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                @auth
                <a href="{{ route('checkout.index') }}"
                   style="display:block;background:#dc3545;color:#fff;font-weight:700;font-size:1rem;padding:16px;border-radius:50px;text-align:center;text-decoration:none;letter-spacing:1px">
                    🔒 INICIAR PAGO
                </a>
                @else
                <a href="/Login"
                   style="display:block;background:#dc3545;color:#fff;font-weight:700;font-size:1rem;padding:16px;border-radius:50px;text-align:center;text-decoration:none">
                    👤 Iniciá sesión para pagar
                </a>
                @endauth

                <div style="text-align:center;margin-top:12px;font-size:.78rem;color:#666">
                    🔒 Pago 100% seguro
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection