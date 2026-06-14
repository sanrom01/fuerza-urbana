@extends('layouts.app')
@section('title', 'Mis Compras')

@section('content')
<div class="container text-white" style="padding-top:80px;padding-bottom:50px">
    <h2 class="fw-bold text-uppercase mb-4" style="letter-spacing:2px">
        <i class="bi bi-box-seam me-2 text-danger"></i>MIS COMPRAS
    </h2>

    @if($ordenes->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-bag-x" style="font-size:4rem;color:#444"></i>
        <h4 class="mt-3 text-secondary">Todavía no realizaste ninguna compra</h4>
        <a href="/Catalogos-de-productos" class="btn btn-danger rounded-pill px-4 mt-3">
            <i class="bi bi-bag me-2"></i>Ir al catálogo
        </a>
    </div>
    @else
    <div class="row justify-content-center">
        <div class="col-md-10">

            @foreach($ordenes as $orden)
            @php
            $badgeColor = match($orden->status) {
                'entregado'  => 'success',
                'enviado'    => 'primary',
                'preparando' => 'warning',
                'confirmado' => 'info',
                'cancelado'  => 'danger',
                default      => 'secondary',
            };
            @endphp

            <div class="mb-4" style="background:#1a1a1a;border-radius:16px;overflow:hidden;border:1px solid #333">

                {{-- CABECERA --}}
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-secondary"
                     style="background:#111">
                    <div class="d-flex gap-3 align-items-center flex-wrap">
                        <div>
                            <span class="text-secondary small">Pedido N°:</span>
                            <strong class="text-white ms-1">#{{ str_pad($orden->id, 5, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                        <span class="text-secondary">|</span>
                        <div>
                            <span class="text-secondary small">Fecha:</span>
                            <strong class="text-white ms-1">{{ $orden->created_at->format('d/m/Y') }}</strong>
                        </div>
                    </div>
                    <span class="badge bg-{{ $badgeColor }} text-uppercase px-3 py-2 rounded-pill fw-bold">
                        {{ $orden->status }}
                    </span>
                </div>

                {{-- PRODUCTOS DE LA ORDEN --}}
                <div class="p-4">
                    @foreach($orden->items as $item)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if($item->product && $item->product->images->isNotEmpty())
                        <img src="{{ $item->product->images->where('is_main',true)->first()?->url }}"
                             style="width:56px;height:56px;object-fit:cover;border-radius:10px" alt="">
                        @else
                        <div style="width:56px;height:56px;border-radius:10px;background:#333;display:flex;align-items:center;justify-content:center">
                            <i class="bi bi-image text-secondary"></i>
                        </div>
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-bold small">{{ $item->product_name }}</div>
                            <div class="text-secondary small">Cantidad: {{ $item->quantity }}</div>
                        </div>
                        <div class="text-danger fw-bold">
                            ${{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach

                    <hr class="border-secondary">

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            @if($orden->tracking_code)
                            <small class="text-secondary">
                                Seguimiento: <code class="text-danger">{{ $orden->tracking_code }}</code>
                            </small>
                            @endif
                            @if($orden->payment)
                            <div class="small text-secondary mt-1">
                                Pago:
                                <span class="badge bg-{{ $orden->payment->status=='aprobado'?'success':'danger' }}">
                                    {{ $orden->payment->status }}
                                </span>
                                — {{ $orden->payment->method }}
                            </div>
                            @endif
                        </div>
                        <div class="col-md-3 text-md-center mt-2 mt-md-0">
                            <span class="text-secondary small d-block">Total pagado:</span>
                            <span class="fw-bold text-danger fs-6">
                                ${{ number_format($orden->total, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="col-md-3 text-md-end mt-2 mt-md-0">
                            <a href="{{ route('mis-compras.detalle', $orden->id) }}"
                               class="btn btn-sm btn-outline-light rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i>Ver Detalle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- PAGINACIÓN --}}
            <div class="mt-3">{{ $ordenes->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
    @endif
</div>
@endsection