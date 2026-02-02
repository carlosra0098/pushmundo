@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card crm-card">
        <div class="card-body">
            <h1>Factura #{{ $item->id }}</h1>
            <p><strong>Cliente:</strong> {{ optional($item->cliente)->nombre }}</p>
            <p><strong>Fecha:</strong> {{ $item->fecha }}</p>
            <p><strong>Total:</strong> {{ $item->total }}</p>
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('facturas.edit', $item) }}" class="btn btn-primary">Editar</a>
            <form action="{{ route('facturas.destroy', $item) }}" method="POST" style="display:inline" class="confirm-delete">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
