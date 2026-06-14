@extends('layouts.app')
@section('title', 'Detalle del pedido #' . str_pad($orden->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="container text-white" style="padding-top:80px;padding-bottom:60px">

    {{-- ENCABEZADO --}}
    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('cliente.ordenes') }}"
           style="background:transparent;border:1px solid #555;color:#fff;padding:8px 16px;border-radius:8px;text-decoration:none;font-size:14px">
            ← Mis compras
        </a>
        <h4 class="fw-bold mb-0">
            Pedido #{{ str_pad($orden->id, 5, '0', STR_PAD_LEFT) }}
        </h4>
        @php
        $badgeColor = match($orden->status) {
            'entregado'  => '#198754',
            'enviado'    => '#0d6efd',
            'preparando' => '#ffc107',
            'confirmado' => '#0dcaf0',
            'cancelado'  => '#dc3545',
            default      => '#6c757d',
        };
        $badgeText = match($orden->status) {
            'preparando' => '#000',
            'confirmado' => '#000',
            default      => '#fff',
        };
        @endphp
        <span style="background:{{ $badgeColor }};color:{{ $badgeText }};padding:6px 16px;border-radius:20px;font-size:13px;font-weight:700;text-transform:uppercase">
            {{ $orden->status }}
        </span>
    </div>

    <div class="row g-4">

        {{-- COLUMNA IZQUIERDA --}}
        <div class="col-lg-8">

            {{-- PRODUCTOS --}}
            <div style="background:#1a1a1a;border-radius:14px;border:1px solid #333;overflow:hidden;margin-bottom:20px">
                <div style="padding:16px 20px;border-bottom:1px solid #333;background:#111">
                    <h6 style="margin:0;font-weight:700;text-transform:uppercase;font-size:13px;color:#dc3545;letter-spacing:1px">
                        🛍 Productos del pedido
                    </h6>
                </div>
                @foreach($orden->items as $item)
                <div style="padding:16px 20px;{{ !$loop->last ? 'border-bottom:1px solid #2a2a2a' : '' }}">
                    <div style="display:flex;align-items:center;gap:16px">
                        {{-- Imagen --}}
                        @php $img = $item->product?->images->where('is_main',true)->first()?->url @endphp
                        @if($img)
                        <img src="{{ $img }}" alt="{{ $item->product_name }}"
                             style="width:72px;height:72px;object-fit:cover;border-radius:10px;flex-shrink:0">
                        @else
                        <div style="width:72px;height:72px;border-radius:10px;background:#333;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <span style="font-size:24px">👕</span>
                        </div>
                        @endif
                        {{-- Info --}}
                        <div style="flex:1">
                            <div style="font-weight:700;margin-bottom:4px">{{ $item->product_name }}</div>
                            <div style="color:#888;font-size:13px">
                                Cantidad: {{ $item->quantity }}
                                &nbsp;·&nbsp;
                                Precio unitario: ${{ number_format($item->unit_price, 0, ',', '.') }}
                            </div>
                        </div>
                        {{-- Subtotal --}}
                        <div style="font-weight:700;color:#dc3545;font-size:16px;white-space:nowrap">
                            ${{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Totales --}}
                <div style="padding:16px 20px;border-top:1px solid #333;background:#111">
                    <div style="display:flex;justify-content:space-between;color:#888;font-size:14px;margin-bottom:6px">
                        <span>Subtotal</span>
                        <span>${{ number_format($orden->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;color:#888;font-size:14px;margin-bottom:12px">
                        <span>Envío</span>
                        <span>${{ number_format($orden->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-weight:700;font-size:20px;border-top:1px solid #333;padding-top:12px">
                        <span>TOTAL</span>
                        <span style="color:#dc3545">${{ number_format($orden->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- TIMELINE DE ESTADO --}}
            <div style="background:#1a1a1a;border-radius:14px;border:1px solid #333;padding:20px;margin-bottom:20px">
                <h6 style="font-weight:700;text-transform:uppercase;font-size:13px;color:#dc3545;letter-spacing:1px;margin-bottom:20px">
                    📦 Estado del pedido
                </h6>
                @php
                $pasos = [
                    'confirmado' => ['✅', 'Confirmado',  'Tu pedido fue confirmado y está siendo procesado.'],
                    'preparando' => ['📦', 'Preparando',  'Estamos preparando tu pedido para el envío.'],
                    'enviado'    => ['🚚', 'Enviado',     'Tu pedido está en camino.'],
                    'entregado'  => ['🏠', 'Entregado',   '¡Tu pedido fue entregado exitosamente!'],
                ];
                $orden_estados = ['confirmado', 'preparando', 'enviado', 'entregado'];
                $indice_actual = array_search($orden->status, $orden_estados);
                @endphp

                @if($orden->status === 'cancelado')
                <div style="text-align:center;padding:20px">
                    <span style="font-size:40px">❌</span>
                    <div style="color:#dc3545;font-weight:700;margin-top:8px">Pedido cancelado</div>
                </div>
                @else
                <div style="display:flex;gap:0;position:relative">
                    @foreach($pasos as $estado => $datos)
                    @php $indice = array_search($estado, $orden_estados); @endphp
                    <div style="flex:1;text-align:center;position:relative">
                        {{-- Línea conectora --}}
                        @if(!$loop->last)
                        <div style="position:absolute;top:20px;left:50%;right:-50%;height:2px;background:{{ $indice < $indice_actual ? '#dc3545' : '#333' }};z-index:0"></div>
                        @endif
                        {{-- Ícono --}}
                        <div style="width:40px;height:40px;border-radius:50%;background:{{ $indice <= $indice_actual ? '#dc3545' : '#333' }};display:flex;align-items:center;justify-content:center;margin:0 auto 8px;position:relative;z-index:1;font-size:18px">
                            {{ $datos[0] }}
                        </div>
                        <div style="font-size:12px;font-weight:700;color:{{ $indice <= $indice_actual ? '#fff' : '#555' }}">
                            {{ $datos[1] }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @if(isset($pasos[$orden->status]))
                <div style="margin-top:16px;padding:12px 16px;background:#111;border-radius:8px;font-size:13px;color:#aaa;text-align:center">
                    {{ $pasos[$orden->status][2] }}
                </div>
                @endif
                @endif

                @if($orden->tracking_code)
                <div style="margin-top:12px;padding:10px 16px;background:#111;border-radius:8px;font-size:13px">
                    🔍 Código de seguimiento:
                    <code style="color:#dc3545;font-weight:700">{{ $orden->tracking_code }}</code>
                </div>
                @endif
            </div>
        </div>

        {{-- COLUMNA DERECHA --}}
        <div class="col-lg-4">

            {{-- INFORMACIÓN GENERAL --}}
            <div style="background:#1a1a1a;border-radius:14px;border:1px solid #333;padding:20px;margin-bottom:20px">
                <h6 style="font-weight:700;text-transform:uppercase;font-size:13px;color:#dc3545;letter-spacing:1px;margin-bottom:16px">
                    📋 Información del pedido
                </h6>
                <table style="width:100%;font-size:13px;border-collapse:collapse">
                    <tr>
                        <td style="color:#888;padding:5px 0">Número</td>
                        <td style="font-weight:700;text-align:right">#{{ str_pad($orden->id, 5, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td style="color:#888;padding:5px 0">Fecha</td>
                        <td style="text-align:right">{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="color:#888;padding:5px 0">Estado</td>
                        <td style="text-align:right">
                            <span style="background:{{ $badgeColor }};color:{{ $badgeText }};padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700">
                                {{ strtoupper($orden->status) }}
                            </span>
                        </td>
                    </tr>
                    @if($orden->factura)
                    <tr>
                        <td style="color:#888;padding:5px 0">Factura</td>
                        <td style="text-align:right;color:#dc3545;font-weight:700">{{ $orden->factura->numero }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="color:#888;padding:5px 0">Items</td>
                        <td style="text-align:right">{{ $orden->items->count() }} producto(s)</td>
                    </tr>
                </table>
            </div>

            {{-- DIRECCIÓN --}}
            <div style="background:#1a1a1a;border-radius:14px;border:1px solid #333;padding:20px;margin-bottom:20px">
                <h6 style="font-weight:700;text-transform:uppercase;font-size:13px;color:#dc3545;letter-spacing:1px;margin-bottom:16px">
                    📍 Dirección de envío
                </h6>
                <div style="font-weight:700">{{ $orden->address->street }}</div>
                <div style="color:#888;font-size:13px;margin-top:4px">
                    {{ $orden->address->city }}, {{ $orden->address->province }}
                </div>
                <div style="color:#888;font-size:13px">CP: {{ $orden->address->postal_code }}</div>
                <div style="color:#888;font-size:13px">{{ $orden->address->country ?? 'Argentina' }}</div>
            </div>

            {{-- PAGO --}}
            @if($orden->payment)
            <div style="background:#1a1a1a;border-radius:14px;border:1px solid #333;padding:20px;margin-bottom:20px">
                <h6 style="font-weight:700;text-transform:uppercase;font-size:13px;color:#dc3545;letter-spacing:1px;margin-bottom:16px">
                    💳 Información de pago
                </h6>
                <table style="width:100%;font-size:13px;border-collapse:collapse">
                    <tr>
                        <td style="color:#888;padding:5px 0">Método</td>
                        <td style="text-align:right;font-weight:700">{{ $orden->payment->method }}</td>
                    </tr>
                    <tr>
                        <td style="color:#888;padding:5px 0">Estado</td>
                        <td style="text-align:right">
                            @if($orden->payment->status === 'aprobado')
                            <span style="background:#198754;color:#fff;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700">✓ APROBADO</span>
                            @else
                            <span style="background:#dc3545;color:#fff;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700">{{ strtoupper($orden->payment->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="color:#888;padding:5px 0">Monto</td>
                        <td style="text-align:right;font-weight:700;color:#dc3545">${{ number_format($orden->payment->amount, 0, ',', '.') }}</td>
                    </tr>
                    @if($orden->payment->transaction_id)
                    <tr>
                        <td style="color:#888;padding:5px 0">Transacción</td>
                        <td style="text-align:right;font-size:11px;color:#dc3545;font-weight:700">{{ $orden->payment->transaction_id }}</td>
                    </tr>
                    @endif
                    @if($orden->payment->paid_at)
                    <tr>
                        <td style="color:#888;padding:5px 0">Fecha pago</td>
                        <td style="text-align:right">{{ $orden->payment->paid_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            @endif

            {{-- ACCIONES --}}
            <div style="display:flex;flex-direction:column;gap:10px">
                <button onclick="window.print()"
                        style="background:#dc3545;border:none;color:#fff;padding:12px;border-radius:50px;font-weight:700;cursor:pointer;font-size:14px">
                    🖨 Imprimir comprobante
                </button>
                <a href="/Catalogos-de-productos"
                   style="background:transparent;border:2px solid #555;color:#fff;padding:12px;border-radius:50px;font-weight:700;text-align:center;text-decoration:none;font-size:14px">
                    🛍 Seguir comprando
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    nav, footer, a[href], button { display: none !important; }
    body { background: white !important; color: black !important; }
    [style*="background:#1a1a1a"] { background: white !important; border: 1px solid #ddd !important; }
    [style*="color:#888"] { color: #555 !important; }
}
</style>
@endpush