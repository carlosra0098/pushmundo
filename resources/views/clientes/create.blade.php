@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-plus"></i> Crear Nuevo Cliente
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading">
                <i class="fas fa-exclamation-triangle"></i> Errores de validación
            </h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm crm-card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Información del Cliente</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('clientes.store') }}" method="POST" novalidate>
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">
                            <strong>Nombre</strong>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre') }}"
                               placeholder="Ej: Juan"
                               required
                               minlength="3"
                               maxlength="100">
                        @error('nombre')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="apellido" class="form-label">
                            <strong>Apellido</strong>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('apellido') is-invalid @enderror" 
                               id="apellido" 
                               name="apellido" 
                               value="{{ old('apellido') }}"
                               placeholder="Ej: Pérez"
                               required
                               minlength="3"
                               maxlength="100">
                        @error('apellido')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            <strong>Email</strong>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="ejemplo@correo.com"
                               required
                               maxlength="100">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">
                            <strong>Teléfono</strong>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="tel" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono') }}"
                               placeholder="+34 612 345 678"
                               required
                               minlength="7"
                               maxlength="20">
                        @error('telefono')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">
                        <strong>Dirección</strong>
                    </label>
                    <textarea class="form-control @error('direccion') is-invalid @enderror" 
                              id="direccion" 
                              name="direccion" 
                              rows="3"
                              placeholder="Calle, número, ciudad, código postal"
                              maxlength="255">{{ old('direccion') }}</textarea>
                    @error('direccion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Campo opcional</small>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Guardar Cliente
                        </button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validación del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        }
    });
</script>
@endpush
@endsection