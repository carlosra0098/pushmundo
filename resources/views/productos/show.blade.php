@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card crm-card">
        <div class="card-body">
            <h1>Producto #{{ $item->id }}</h1>
            <p><strong>Nombre:</strong> {{ $item->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $item->descripcion }}</p>
            <p><strong>Precio:</strong> {{ $item->precio }}</p>
            <p><strong>Proveedor:</strong> {{ optional($item->proveedor)->nombre }}</p>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('productos.edit', $item) }}" class="btn btn-primary">Editar</a>
            <form action="{{ route('productos.destroy', $item) }}" method="POST" style="display:inline" class="confirm-delete">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
