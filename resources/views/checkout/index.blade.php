@extends('layouts.app')
@section('title', 'Finalizar compra')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-white mb-4">
        <i class="bi bi-lock-fill text-danger me-2"></i>Finalizar compra
    </h2>

    @if($errors->any())
    <div class="alert alert-danger rounded-3 mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('checkout.procesar') }}" method="POST" id="formCheckout">
        @csrf
        <div class="row g-4">

            {{-- COLUMNA IZQUIERDA --}}
            <div class="col-lg-7">

                {{-- DATOS DE ENVÍO --}}
                <div class="card bg-dark border-secondary text-white mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>Datos de envío
                        </h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-secondary small text-uppercase">Calle y número *</label>
                                <input type="text" name="calle" value="{{ old('calle') }}"
                                       class="form-control bg-black text-white border-secondary"
                                       placeholder="Ej: Av. Independencia 1234" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-secondary small text-uppercase">Ciudad *</label>
                                <input type="text" name="ciudad" value="{{ old('ciudad', 'Corrientes') }}"
                                       class="form-control bg-black text-white border-secondary" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-secondary small text-uppercase">Provincia *</label>
                                <select name="provincia" class="form-select bg-black text-white border-secondary" required>
                                    @foreach(['Buenos Aires','CABA','Catamarca','Chaco','Chubut','Córdoba','Corrientes','Entre Ríos','Formosa','Jujuy','La Pampa','La Rioja','Mendoza','Misiones','Neuquén','Río Negro','Salta','San Juan','San Luis','Santa Cruz','Santa Fe','Santiago del Estero','Tierra del Fuego','Tucumán'] as $prov)
                                    <option value="{{ $prov }}" {{ old('provincia','Corrientes')==$prov ? 'selected':'' }}>{{ $prov }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-secondary small text-uppercase">CP *</label>
                                <input type="text" name="codigo_postal" value="{{ old('codigo_postal') }}"
                                       class="form-control bg-black text-white border-secondary"
                                       placeholder="W3400" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DATOS DE PAGO --}}
                <div class="card bg-dark border-secondary text-white">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-credit-card-fill text-danger me-2"></i>Datos de pago
                        </h5>

                        {{-- TIPO DE TARJETA --}}
                        <div class="mb-4">
                            <label class="form-label text-secondary small text-uppercase">Tipo de tarjeta *</label>
                            <div class="d-flex gap-3 flex-wrap">
                                @foreach(['visa'=>'VISA','mastercard'=>'Mastercard','amex'=>'Amex','debito'=>'Débito'] as $val => $label)
                                <label class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 border border-secondary"
                                       style="cursor:pointer;min-width:110px"
                                       onclick="this.closest('.d-flex').querySelectorAll('label').forEach(l=>l.style.borderColor='#6c757d');this.style.borderColor='#dc3545'">
                                    <input type="radio" name="tipo_tarjeta" value="{{ $val }}"
                                           class="form-check-input mt-0"
                                           {{ old('tipo_tarjeta')==$val ? 'checked':'' }}
                                           {{ $val=='visa' && !old('tipo_tarjeta') ? 'checked':'' }}>
                                    <span class="small fw-bold">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- NÚMERO DE TARJETA --}}
                        <div class="mb-3">
                            <label class="form-label text-secondary small text-uppercase">Número de tarjeta *</label>
                            <input type="text" name="num_tarjeta" id="num_tarjeta"
                                   class="form-control bg-black text-white border-secondary form-control-lg"
                                   placeholder="1234 5678 9012 3456"
                                   maxlength="19"
                                   value="{{ old('num_tarjeta') }}"
                                   oninput="formatarTarjeta(this)" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label text-secondary small text-uppercase">Vencimiento *</label>
                                <input type="text" name="vencimiento"
                                       class="form-control bg-black text-white border-secondary"
                                       placeholder="MM/AA" maxlength="5"
                                       value="{{ old('vencimiento') }}"
                                       oninput="formatarVencimiento(this)" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-secondary small text-uppercase">Código de seguridad *</label>
                                <input type="text" name="cvv"
                                       class="form-control bg-black text-white border-secondary"
                                       placeholder="CVV" maxlength="4"
                                       oninput="this.value=this.value.replace(/\D/,'')"
                                       value="{{ old('cvv') }}" required>
                            </div>
                        </div>

                        <div class="mb-1">
                            <label class="form-label text-secondary small text-uppercase">Titular de la tarjeta *</label>
                            <input type="text" name="titular"
                                   class="form-control bg-black text-white border-secondary"
                                   placeholder="Nombre como figura en la tarjeta"
                                   value="{{ old('titular') }}"
                                   style="text-transform:uppercase" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RESUMEN --}}
            <div class="col-lg-5">
                <div class="card bg-dark border-secondary text-white sticky-top" style="top:1.5rem">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Resumen del pedido</h5>

                        @foreach($carrito as $id => $item)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $item['imagen'] }}"
                                 style="width:50px;height:50px;object-fit:cover;border-radius:8px" alt="">
                            <div class="flex-grow-1">
                                <div class="small fw-500">{{ $item['nombre'] }}</div>
                                <div class="small text-secondary">x{{ $item['cantidad'] }}</div>
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
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                            <span>Total</span>
                            <span class="text-danger">${{ number_format($subtotal + 1000, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-3 fw-bold fs-6" id="btnComprar">
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
    </form>
</div>
@endsection

@push('scripts')
<script>
function formatarTarjeta(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = v.replace(/(.{4})/g, '$1 ').trim();
    // Guardar solo dígitos en campo oculto
    document.querySelector('[name=num_tarjeta]').value = v;
}

function formatarVencimiento(input) {
    let v = input.value.replace(/\D/g, '').substring(0, 4);
    if (v.length >= 2) v = v.substring(0,2) + '/' + v.substring(2);
    input.value = v;
}

document.getElementById('formCheckout').addEventListener('submit', function() {
    const btn = document.getElementById('btnComprar');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
});
</script>
@endpush
