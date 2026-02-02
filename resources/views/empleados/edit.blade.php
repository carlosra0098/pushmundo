@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2>Editar Empleado</h2>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('empleados.update', $item) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $item->nombre) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $item->apellido) }}" required> <!-- Cambiado aquí y añadido required -->
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $item->email) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $item->telefono) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Puesto</label>
                    <input type="text" name="puesto" class="form-control" value="{{ old('puesto', $item->puesto) }}">
                </div>
                <button class="btn btn-primary">Actualizar</button>
                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection