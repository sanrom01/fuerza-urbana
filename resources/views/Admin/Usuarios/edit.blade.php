@extends('layouts.admin')
@section('title', 'Editar usuario')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.usuarios.show', $usuario) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="mb-0 fw-600">Editar: {{ $usuario->name }}</h5>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-card p-4">

            @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $usuario->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $usuario->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $usuario->phone) }}" placeholder="+54 9 ...">
                </div>

                <div class="mb-4">
                    <label class="form-label">Rol *</label>
                    <select name="role" class="form-select">
                        <option value="cliente" {{ old('role', $usuario->role) == 'cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="admin"   {{ old('role', $usuario->role) == 'admin'   ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @if($usuario->id === auth()->id())
                    <small class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i>Estás editando tu propia cuenta. Tené cuidado al cambiar el rol.</small>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-red px-4">
                        <i class="bi bi-check-lg me-1"></i>Guardar cambios
                    </button>
                    <a href="{{ route('admin.usuarios.show', $usuario) }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection