@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh; padding-top: 40px; padding-bottom: 40px;">
    <div class="col-md-5">
        <div class="card p-4 border border-secondary bg-dark text-white shadow-lg" style="border-radius: 15px;">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-uppercase letter-spacing-2">REGISTRARSE</h2>
                <p class="text-secondary small">Creá tu cuenta en segundos</p>
            </div>

            <<form action="{{ route('registro.guardar') }}" method="POST">
                @csrf <div class="mb-3">
                    <label for="name" class="form-label fw-bold text-uppercase small" style="letter-spacing: 1px;">Nombre Completo</label>
                    <input type="text" name="name" id="name" class="form-control form-control-lg bg-black text-white border-secondary rounded-3" placeholder="Juan Pérez" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-uppercase small" style="letter-spacing: 1px;">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control form-control-lg bg-black text-white border-secondary rounded-3" placeholder="tu@email.com" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold text-uppercase small" style="letter-spacing: 1px;">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control form-control-lg bg-black text-white border-secondary rounded-3" placeholder="Mínimo 8 caracteres" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold text-uppercase small" style="letter-spacing: 1px;">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg bg-black text-white border-secondary rounded-3" placeholder="Repetí tu contraseña" required>
                </div>

                <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold rounded-pill text-uppercase mb-3" style="letter-spacing: 1px;">
                    CREAR CUENTA
                </button>

                <div class="text-center">
                    <p class="text-secondary small mb-0">¿Ya tenés cuenta? <a href="/Login" class="text-danger fw-bold text-decoration-none">Ingresá acá</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection