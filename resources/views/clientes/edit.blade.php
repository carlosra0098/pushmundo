@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-edit"></i> Editar Cliente
            </h1>
            <small class="text-muted">ID: {{ $cliente->id }} | Registrado: {{ $cliente->created_at->format('d/m/Y H:i') }}</small>
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

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Información del Cliente</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

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
                               value="{{ old('nombre', $cliente->nombre) }}"
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
                               value="{{ old('apellido', $cliente->apellido) }}"
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
                               value="{{ old('email', $cliente->email) }}"
                               placeholder="ejemplo@correo.com"
                               required
                               maxlength="100">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Único en la base de datos</small>
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
                               value="{{ old('telefono', $cliente->telefono) }}"
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
                              maxlength="255">{{ old('direccion', $cliente->direccion) }}</textarea>
                    @error('direccion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Campo opcional</small>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="d-flex gap-3 align-items-center flex-wrap">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Actualizar Cliente
                            </button>
                            <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <!-- Botón visible de eliminación (no es un formulario) -->
                            <button type="button" id="deleteBtnVisible" class="btn btn-danger btn-lg">
                                <i class="fas fa-trash"></i> Eliminar Cliente
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Formulario oculto de eliminación (se envía desde el botón visible) -->
            <form id="deleteForm" action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<script>
    // Validación del formulario y registro de handlers (script inline para evitar dependencias de layout)
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action*="update"]');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        }

        // Registrar handler para el botón visible de eliminación
        const deleteBtn = document.getElementById('deleteBtnVisible');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                confirmDelete();
            });
        }
    });

    // Confirmar eliminación y enviar via fetch (POST + _method=DELETE)
    function confirmDelete() {
        const clienteName = "{{ $cliente->nombre }} {{ $cliente->apellido }}";
        const message = `¿Estás completamente seguro de que deseas eliminar al cliente "${clienteName}"? Esta acción no se puede deshacer.`;
        console.debug('confirmDelete called for', clienteName);
        if (!confirm(message)) {
            console.debug('Eliminación cancelada por el usuario');
            return false;
        }

        const hiddenForm = document.getElementById('deleteForm');
        if (!hiddenForm) {
            console.error('Formulario de eliminación no encontrado');
            alert('No se pudo procesar la eliminación (formulario no encontrado).');
            return false;
        }

        const action = hiddenForm.action;
        // Obtener token CSRF
        const tokenInput = hiddenForm.querySelector('input[name="_token"]');
        const token = tokenInput ? tokenInput.value : null;

        // Construir FormData
        const data = new FormData();
        data.append('_method', 'DELETE');
        if (token) data.append('_token', token);

        console.debug('Enviando petición DELETE a', action);

        fetch(action, {
            method: 'POST',
            credentials: 'same-origin',
            body: data,
        }).then(function(response) {
            if (response.ok) {
                console.debug('Eliminado correctamente, redirigiendo');
                // Redirigir al índice
                window.location.href = "{{ route('clientes.index') }}";
            } else {
                console.error('Respuesta de eliminación no OK:', response.status);
                response.text().then(function(t) { console.error(t); alert('Error al eliminar el cliente.'); });
            }
        }).catch(function(err) {
            console.error('Error en fetch de eliminación:', err);
            alert('Error de red al eliminar el cliente.');
        });

        return false;
    }
</script>
@endsection