@extends('layouts.app')
@section('title', 'Contacto')

@section('content')
<main>

    <!-- HERO -->
    <section class="hero d-flex align-items-center text-center text-white">
        <div class="container">
            <h1 class="display-4 fw-bold">Contacto</h1>
            <p class="lead">Estamos para ayudarte</p>
        </div>
    </section>

    <!-- INFO + FORM -->
    <section class="py-5 bg-dark text-light">
        <div class="container">
            <div class="row">

                <!-- DATOS -->
                <div class="col-md-5 mb-4">
                    <h3 class="text-danger mb-4">Información Legal</h3>
                    <p><strong>Titular:</strong> Lucas Benítez</p>
                    <p><strong>Razón Social:</strong> Fuerza Urbana S.R.L.</p>
                    <p><strong>Domicilio:</strong> Av. Independencia 1234, Corrientes, Argentina</p>
                    <p><strong>Teléfono:</strong> +54 379 4123456</p>
                    <p><strong>Email:</strong> contacto@fuerzaurbana.com</p>

                    <h4 class="text-danger mt-4">Redes</h4>
                    <p>Instagram: @fuerzaurbana</p>
                    <p>WhatsApp: +54 379 4123456</p>

                    <div class="mt-4">
                        <h4 class="text-danger mb-3">Nuestra ubicación</h4>
                        <div class="mapa">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3539.9999999999995!2d-58.8344!3d-27.4806!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456b1234567890%3A0x123456789abcdef!2sCorrientes%2C%20Argentina!5e0!3m2!1ses!2sar!4v0000000000000"
                                width="100%" height="300" style="border:0;"
                                allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- FORMULARIO -->
                <div class="col-md-7">
                    <h3 class="text-danger mb-4">Envíanos un mensaje</h3>

                    {{-- AVISO DE ÉXITO --}}
                    @if(session('contacto_ok'))
                    <div class="alert alert-success d-flex align-items-center gap-3 rounded-3 mb-4"
                         style="border-left:4px solid #198754">
                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                        <div>
                            <div class="fw-bold">¡Mensaje enviado!</div>
                            <div class="small">{{ session('contacto_ok') }}</div>
                        </div>
                    </div>
                    @endif

                    {{-- ERRORES --}}
                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0 small">
                            @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('contacto.enviar') }}" method="POST">
                        @csrf

                        @auth
                        {{-- USUARIO LOGUEADO: solo muestra su info y el campo mensaje --}}
                        <div class="alert alert-dark border border-secondary d-flex align-items-center gap-3 mb-4 rounded-3">
                            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center fw-bold"
                                 style="width:40px;height:40px;font-size:.85rem;flex-shrink:0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-white">{{ Auth::user()->name }}</div>
                                <div class="text-secondary small">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        @else
                        {{-- INVITADO: muestra todos los campos --}}
                        <div class="mb-3">
                            <input type="text" name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   placeholder="Nombre completo *"
                                   value="{{ old('nombre') }}" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Correo electrónico *"
                                   value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <input type="tel" name="telefono"
                                   class="form-control"
                                   placeholder="Teléfono (opcional)"
                                   value="{{ old('telefono') }}">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="asunto"
                                   class="form-control"
                                   placeholder="Asunto (opcional)"
                                   value="{{ old('asunto') }}">
                        </div>
                        @endauth

                        {{-- MENSAJE (siempre visible) --}}
                        <div class="mb-4">
                            <textarea name="mensaje" rows="5"
                                      class="form-control @error('mensaje') is-invalid @enderror"
                                      placeholder="Escribí tu mensaje aquí..."
                                      required>{{ old('mensaje') }}</textarea>
                            @error('mensaje')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill py-3">
                            <i class="bi bi-send me-2"></i>Enviar mensaje
                        </button>

                        @guest
                        <p class="text-secondary small text-center mt-3">
                            ¿Tenés cuenta?
                            <a href="/Login" class="text-danger">Iniciá sesión</a>
                            para enviar tu mensaje más fácil.
                        </p>
                        @endguest
                    </form>
                </div>

            </div>
        </div>
    </section>

</main>
@endsection