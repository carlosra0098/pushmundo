@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card crm-card">
        <div class="card-body">
            <h1>Producto #{{ $item->id }}</h1>
            <p><strong>Nombre:</strong> {{ $item->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $item->descripcion }}</p>
            <p>
                <strong>Imagen:</strong>
                @if($item->imagen_url)
                    <img src="{{ $item->imagen_url }}" alt="{{ $item->nombre }}" width="90" height="90" class="rounded object-fit-cover ms-2">
                @else
                    <span class="text-muted">Sin imagen</span>
                @endif
            </p>
            <p>
                <strong>Ficha PDF:</strong>
                @if($item->archivo_pdf_url)
                    <a href="{{ $item->archivo_pdf_url }}" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">Abrir PDF</a>
                @else
                    <span class="text-muted">Sin archivo</span>
                @endif
            </p>
            <p><strong>Precio:</strong> {{ $item->precio }}</p>
            <p><strong>Proveedor:</strong> {{ optional($item->proveedor)->nombre }}</p>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('productos.edit', $item) }}" class="btn btn-primary">Editar</a>
            @can('delete-records')
            <form action="{{ route('productos.destroy', $item) }}" method="POST" style="display:inline" class="confirm-delete">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection
