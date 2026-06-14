@extends('layouts.app')
@section('title', 'Finalizar compra')

@section('content')
<div class="container py-5">

    {{-- TÍTULO --}}
    <h2 class="fw-bold text-white mb-4">
        <i class="bi bi-lock-fill text-danger me-2"></i>Finalizar compra
    </h2>

    {{-- ERRORES --}}
    @if($errors->any())
    <div class="alert alert-danger rounded-3 mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- INDICADOR DE PASOS --}}
    <div class="d-flex align-items-center gap-0 mb-5" id="indicadorPasos">
        {{-- Paso 1 --}}
        <div class="d-flex align-items-center gap-2" id="labelPaso1">
            <div id="circulo1"
                 style="width:36px;height:36px;border-radius:50%;background:#dc3545;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0">
                1
            </div>
            <span class="text-white fw-600 d-none d-sm-inline">Datos de envío</span>
        </div>
        <div style="flex:1;height:2px;background:#333;margin:0 12px;max-width:80px"></div>
        {{-- Paso 2 --}}
        <div class="d-flex align-items-center gap-2" id="labelPaso2">
            <div id="circulo2"
                 style="width:36px;height:36px;border-radius:50%;background:#333;color:#aaa;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0">
                2
            </div>
            <span class="text-secondary fw-600 d-none d-sm-inline" id="textoPaso2">Datos de pago</span>
        </div>
    </div>

    <form action="{{ route('checkout.procesar') }}" method="POST" id="formCheckout">
        @csrf
        <div class="row g-4">

            {{-- COLUMNA IZQUIERDA --}}
            <div class="col-lg-7">

                {{-- ══ PASO 1: ENVÍO ════════════════════════════════════ --}}
                <div id="paso1">
                    <div class="card border-0 text-white mb-4"
                         style="background:#1a1a1a;border-radius:16px">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>Datos de envío
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-secondary small text-uppercase">
                                        Calle y número *
                                    </label>
                                    <input type="text" name="calle" id="calle"
                                           value="{{ old('calle') }}"
                                           class="form-control bg-black text-white border-secondary"
                                           placeholder="Ej: Av. Independencia 1234">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-secondary small text-uppercase">Ciudad *</label>
                                    <input type="text" name="ciudad" id="ciudad"
                                           value="{{ old('ciudad', 'Corrientes') }}"
                                           class="form-control bg-black text-white border-secondary">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-secondary small text-uppercase">Provincia *</label>
                                    <select name="provincia" id="provincia"
                                            class="form-select bg-black text-white border-secondary">
                                        @foreach(['Buenos Aires','CABA','Catamarca','Chaco','Chubut','Córdoba','Corrientes','Entre Ríos','Formosa','Jujuy','La Pampa','La Rioja','Mendoza','Misiones','Neuquén','Río Negro','Salta','San Juan','San Luis','Santa Cruz','Santa Fe','Santiago del Estero','Tierra del Fuego','Tucumán'] as $prov)
                                        <option value="{{ $prov }}" {{ old('provincia','Corrientes')==$prov ? 'selected':'' }}>{{ $prov }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label text-secondary small text-uppercase">CP *</label>
                                    <input type="text" name="codigo_postal" id="codigo_postal"
                                           value="{{ old('codigo_postal') }}"
                                           class="form-control bg-black text-white border-secondary"
                                           placeholder="W3400">
                                </div>
                            </div>

                            {{-- BOTÓN SIGUIENTE --}}
                            <button type="button" onclick="irPaso2()"
                                    class="btn btn-danger w-100 py-3 fw-bold mt-4 rounded-pill">
                                Siguiente — Datos de pago
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ══ PASO 2: PAGO ══════════════════════════════════════ --}}
                <div id="paso2" style="display:none">
                    <div class="card border-0 text-white"
                         style="background:#1a1a1a;border-radius:16px">
                        <div class="card-body p-4">

                            {{-- Resumen dirección elegida --}}
                            <div class="p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center"
                                 style="background:#111;border:1px solid #333">
                                <div>
                                    <div class="small text-secondary text-uppercase fw-600 mb-1">
                                        <i class="bi bi-geo-alt me-1 text-danger"></i>Dirección de envío
                                    </div>
                                    <div class="text-white small" id="resumenDireccion"></div>
                                </div>
                                <button type="button" onclick="volverPaso1()"
                                        class="btn btn-sm btn-outline-secondary rounded-pill">
                                    <i class="bi bi-pencil me-1"></i>Editar
                                </button>
                            </div>

                            <h5 class="fw-bold mb-4">
                                <i class="bi bi-credit-card-fill text-danger me-2"></i>Datos de pago
                            </h5>

                            {{-- TIPO DE TARJETA --}}
                            <div class="mb-4">
                                <label class="form-label text-secondary small text-uppercase">
                                    Tipo de tarjeta *
                                </label>
                                <div class="d-flex gap-2 flex-wrap" id="tiposTarjeta">
                                    @foreach(['visa'=>'VISA','mastercard'=>'Mastercard','amex'=>'Amex','debito'=>'Débito'] as $val => $label)
                                    <label class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                                           style="cursor:pointer;border:2px solid #444;transition:.15s"
                                           onclick="seleccionarTarjeta(this)">
                                        <input type="radio" name="tipo_tarjeta" value="{{ $val }}"
                                               class="form-check-input mt-0"
                                               {{ $val=='visa' && !old('tipo_tarjeta') ? 'checked':'' }}
                                               {{ old('tipo_tarjeta')==$val ? 'checked':'' }}>
                                        <span class="small fw-bold text-white">{{ $label }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- NÚMERO DE TARJETA --}}
                            <div class="mb-3">
                                <label class="form-label text-secondary small text-uppercase">
                                    Número de tarjeta *
                                </label>
                                <input type="text" name="num_tarjeta" id="num_tarjeta"
                                       class="form-control bg-black text-white border-secondary form-control-lg"
                                       placeholder="1234 5678 9012 3456"
                                       maxlength="19"
                                       value="{{ old('num_tarjeta') }}"
                                       oninput="formatarTarjeta(this)">
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label text-secondary small text-uppercase">
                                        Vencimiento *
                                    </label>
                                    <input type="text" name="vencimiento"
                                           class="form-control bg-black text-white border-secondary"
                                           placeholder="MM/AA" maxlength="5"
                                           value="{{ old('vencimiento') }}"
                                           oninput="formatarVencimiento(this)">
                                </div>
                                <div class="col-6">
                                    <label class="form-label text-secondary small text-uppercase">
                                        Cód. de seguridad *
                                    </label>
                                    <input type="text" name="cvv"
                                           class="form-control bg-black text-white border-secondary"
                                           placeholder="CVV" maxlength="4"
                                           value="{{ old('cvv') }}"
                                           oninput="this.value=this.value.replace(/\D/g,'')">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-secondary small text-uppercase">
                                    Titular de la tarjeta *
                                </label>
                                <input type="text" name="titular"
                                       class="form-control bg-black text-white border-secondary"
                                       placeholder="Nombre como figura en la tarjeta"
                                       value="{{ old('titular') }}"
                                       style="text-transform:uppercase">
                            </div>

                            {{-- BOTÓN CONFIRMAR --}}
                            <button type="submit" class="btn btn-danger w-100 py-3 fw-bold rounded-pill fs-6"
                                    id="btnComprar">
                                <i class="bi bi-check-circle me-2"></i>CONFIRMAR COMPRA
                            </button>
                            <div class="text-center mt-3">
                                <small class="text-secondary">
                                    <i class="bi bi-shield-lock me-1 text-success"></i>
                                    Pago 100% seguro y encriptado
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RESUMEN (siempre visible) --}}
            <div class="col-lg-5">
                <div class="card border-0 text-white sticky-top"
                     style="background:#1a1a1a;border-radius:16px;top:1.5rem">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Resumen del pedido</h5>

                        @foreach($carrito as $id => $item)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $item['imagen'] }}"
                                 style="width:50px;height:50px;object-fit:cover;border-radius:8px"
                                 onerror="this.src='https://picsum.photos/seed/1/50/50'" alt="">
                            <div class="flex-grow-1">
                                <div class="small fw-500">{{ $item['nombre'] }}</div>
                                <div class="small text-secondary">
                                    x{{ $item['cantidad'] }}
                                    @if(isset($item['talle'])) · Talle {{ $item['talle'] }} @endif
                                </div>
                            </div>
                            <span class="small fw-bold">
                                ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach

                        <hr class="border-secondary">
                        <div class="d-flex justify-content-between mb-2 text-secondary small">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-secondary small">
                            <span>Envío</span>
                            <span>$1.000</span>
                        </div>
                        <hr class="border-secondary">
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span class="text-danger">${{ number_format($subtotal + 1000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// ── Si hay errores de validación del servidor, ir directo al paso 2
@if($errors->any())
window.addEventListener('DOMContentLoaded', function() { mostrarPaso2(); });
@endif

function irPaso2() {
    // Validar campos de envío
    var calle  = document.getElementById('calle').value.trim();
    var ciudad = document.getElementById('ciudad').value.trim();
    var cp     = document.getElementById('codigo_postal').value.trim();

    if (!calle || !ciudad || !cp) {
        // Marcar campos vacíos
        [['calle', calle], ['ciudad', ciudad], ['codigo_postal', cp]].forEach(function(pair) {
            var el = document.getElementById(pair[0]);
            if (!pair[1]) {
                el.style.borderColor = '#dc3545';
                el.focus();
            } else {
                el.style.borderColor = '#555';
            }
        });
        // Scroll al primer campo vacío
        document.getElementById('calle').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    mostrarPaso2();
}

function mostrarPaso2() {
    // Actualizar resumen de dirección
    var calle    = document.getElementById('calle').value;
    var ciudad   = document.getElementById('ciudad').value;
    var provincia = document.getElementById('provincia').value;
    var cp       = document.getElementById('codigo_postal').value;
    document.getElementById('resumenDireccion').textContent =
        calle + ', ' + ciudad + ', ' + provincia + ' (CP ' + cp + ')';

    // Mostrar paso 2
    document.getElementById('paso1').style.display = 'none';
    document.getElementById('paso2').style.display = 'block';

    // Actualizar indicador
    document.getElementById('circulo1').style.background = '#198754';
    document.getElementById('circulo1').innerHTML = '<i class="bi bi-check" style="font-size:16px"></i>';
    document.getElementById('circulo2').style.background = '#dc3545';
    document.getElementById('circulo2').style.color = '#fff';
    document.getElementById('textoPaso2').className = 'text-white fw-600 d-none d-sm-inline';

    // Scroll arriba
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function volverPaso1() {
    document.getElementById('paso2').style.display = 'none';
    document.getElementById('paso1').style.display = 'block';

    // Restaurar indicador
    document.getElementById('circulo1').style.background = '#dc3545';
    document.getElementById('circulo1').innerHTML = '1';
    document.getElementById('circulo2').style.background = '#333';
    document.getElementById('circulo2').style.color = '#aaa';
    document.getElementById('textoPaso2').className = 'text-secondary fw-600 d-none d-sm-inline';

    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function seleccionarTarjeta(label) {
    document.querySelectorAll('#tiposTarjeta label').forEach(function(l) {
        l.style.borderColor = '#444';
    });
    label.style.borderColor = '#dc3545';
    label.querySelector('input').checked = true;
}

// Marcar VISA como seleccionada por defecto
document.addEventListener('DOMContentLoaded', function() {
    var visaLabel = document.querySelector('#tiposTarjeta label');
    if (visaLabel) visaLabel.style.borderColor = '#dc3545';
});

function formatarTarjeta(input) {
    var v = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = v.replace(/(.{4})/g, '$1 ').trim();
}

function formatarVencimiento(input) {
    var v = input.value.replace(/\D/g, '').substring(0, 4);
    if (v.length >= 2) v = v.substring(0,2) + '/' + v.substring(2);
    input.value = v;
}

document.getElementById('formCheckout').addEventListener('submit', function() {
    var btn = document.getElementById('btnComprar');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
});
</script>
@endpush