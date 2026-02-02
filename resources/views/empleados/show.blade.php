@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card crm-card">
        <div class="card-body">
            <h1>Empleado #{{ $item->id }}</h1>
            <p><strong>Nombre:</strong> {{ $item->nombre }}</p>
            <p><strong>Email:</strong> {{ $item->email }}</p>
            <p><strong>Puesto:</strong> {{ $item->puesto }}</p>
            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('empleados.edit', $item) }}" class="btn btn-primary">Editar</a>
            <form action="{{ route('empleados.destroy', $item) }}" method="POST" style="display:inline" class="confirm-delete">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
