@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card crm-card">
        <div class="card-body">
            <h1>Proveedor #{{ $item->id }}</h1>
            <p><strong>Nombre:</strong> {{ $item->nombre }}</p>
    <p><strong>Contacto:</strong> {{ $item->contacto }}</p>
    <p><strong>Teléfono:</strong> {{ $item->telefono }}</p>
    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Volver</a>
    <a href="{{ route('proveedores.edit', $item) }}" class="btn btn-primary">Editar</a>
    <form action="{{ route('proveedores.destroy', $item) }}" method="POST" style="display:inline" class="confirm-delete">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Eliminar</button>
    </form>
</div>
@endsection
