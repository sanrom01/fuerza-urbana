@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 75vh; padding-top: 40px;">
    <div class="col-md-5">
        <div class="card p-4 border border-secondary bg-dark text-white shadow-lg" style="border-radius: 15px;">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-uppercase">INGRESAR</h2>
                <p class="text-secondary small">Sumate a la Fuerza Urbana</p>
            </div>

            {{-- ERRORES --}}
            @if($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-uppercase small" style="letter-spacing: 1px;">
                        Correo Electrónico
                    </label>
                    <input type="email" name="email" id="email"
                           class="form-control form-control-lg bg-black text-white border-secondary rounded-3"
                           placeholder="tu@email.com"
                           value="{{ old('email') }}"
                           required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold text-uppercase small" style="letter-spacing: 1px;">
                        Contraseña
                    </label>
                    <input type="password" name="password" id="password"
                           class="form-control form-control-lg bg-black text-white border-secondary rounded-3"
                           placeholder="••••••••" required>
                </div>

                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember"
                               class="form-check-input bg-black border-secondary">
                        <label class="form-check-label text-secondary small" for="remember">
                            Recordar mi sesión
                        </label>
                    </div>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-danger small text-decoration-none">
                        ¿Olvidaste tu contraseña?
                    </a>
                    @endif
                </div>

                <button type="submit"
                        class="btn btn-danger btn-lg w-100 fw-bold rounded-pill text-uppercase mb-3"
                        style="letter-spacing: 1px;">
                    INICIAR SESIÓN
                </button>

                <div class="text-center">
                    <p class="text-secondary small mb-0">
                        ¿No tenés cuenta?
                        <a href="{{ route('register') }}" class="text-danger fw-bold text-decoration-none">
                            Registrate acá
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection