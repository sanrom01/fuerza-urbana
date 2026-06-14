@extends('layouts.admin')
@section('title', 'Consulta #'.$consulta->id)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.consultas.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">Consulta #{{ $consulta->id }}</h5>
    <span class="badge {{ $consulta->estado=='pendiente' ? 'bg-warning text-dark' : 'bg-success' }}">
        {{ $consulta->estado }}
    </span>
</div>

<div class="row g-4">
    <div class="col-lg-8">

        {{-- MENSAJE --}}
        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3"><i class="bi bi-chat-text me-2 text-danger"></i>Mensaje del cliente</h6>
            @if($consulta->asunto)
            <div class="fw-500 mb-2">Asunto: {{ $consulta->asunto }}</div>
            @endif
            <div class="p-3 rounded-3" style="background:#f8f7fd;border-left:3px solid #e63946">
                <p class="mb-0">{{ $consulta->mensaje }}</p>
            </div>
            <div class="text-muted small mt-2">
                <i class="bi bi-clock me-1"></i>{{ $consulta->created_at->format('d/m/Y H:i') }}
            </div>
        </div>

        {{-- RESPUESTA --}}
        @if($consulta->estado === 'respondida')
        <div class="admin-card p-4 mb-3">
            <h6 class="fw-600 mb-3"><i class="bi bi-reply me-2 text-success"></i>Respuesta enviada</h6>
            <div class="p-3 rounded-3" style="background:#f0fff4;border-left:3px solid #198754">
                <p class="mb-0">{{ $consulta->respuesta }}</p>
            </div>
            <div class="text-muted small mt-2">
                <i class="bi bi-clock me-1"></i>{{ $consulta->respondida_at?->format('d/m/Y H:i') }}
            </div>
        </div>
        @else
        {{-- FORMULARIO RESPUESTA --}}
        <div class="admin-card p-4">
            <h6 class="fw-600 mb-3"><i class="bi bi-reply me-2 text-danger"></i>Responder consulta</h6>
            <form action="{{ route('admin.consultas.responder', $consulta) }}" method="POST">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger small">{{ $errors->first() }}</div>
                @endif
                <div class="mb-3">
                    <label class="form-label">Respuesta *</label>
                    <textarea name="respuesta" rows="5"
                              class="form-control @error('respuesta') is-invalid @enderror"
                              placeholder="Escribí tu respuesta al cliente..."
                              required>{{ old('respuesta') }}</textarea>
                    @error('respuesta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-red">
                    <i class="bi bi-send me-2"></i>Marcar como respondida
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h6 class="fw-600 mb-3"><i class="bi bi-person me-2"></i>Datos del remitente</h6>
            <table class="table table-sm mb-0">
                <tr><td class="text-muted small">Nombre</td><td class="small fw-500">{{ $consulta->nombre }}</td></tr>
                <tr><td class="text-muted small">Email</td>
                    <td><a href="mailto:{{ $consulta->email }}" class="small text-danger">{{ $consulta->email }}</a></td></tr>
                <tr><td class="text-muted small">Usuario</td>
                    <td class="small">{{ $consulta->user ? $consulta->user->name : 'Invitado' }}</td></tr>
                <tr><td class="text-muted small">Fecha</td>
                    <td class="small">{{ $consulta->created_at->format('d/m/Y H:i') }}</td></tr>
            </table>

            @if($consulta->user)
            <a href="{{ route('admin.usuarios.show', $consulta->user) }}"
               class="btn btn-outline-secondary btn-sm w-100 mt-3">
                <i class="bi bi-person me-1"></i>Ver perfil del usuario
            </a>
            @endif

            <hr>

            <form action="{{ route('admin.consultas.destroy', $consulta) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar esta consulta?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm w-100">
                    <i class="bi bi-trash3 me-1"></i>Eliminar consulta
                </button>
            </form>
        </div>
    </div>
</div>
@endsection