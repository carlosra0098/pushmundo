@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card crm-card">
        <div class="card-body">
            <h1>Factura #{{ $item->id }}</h1>
            <p><strong>Cliente:</strong> {{ optional($item->cliente)->nombre }}</p>
            <p><strong>Fecha:</strong> {{ $item->fecha }}</p>
            <p><strong>Total:</strong> {{ $item->total }}</p>
            <p>
                <strong>PDF:</strong>
                @if($item->archivo_pdf_url)
                    <a href="{{ $item->archivo_pdf_url }}" target="_blank" class="btn btn-sm btn-outline-secondary ms-2">Abrir PDF</a>
                @else
                    <span class="text-muted">Sin archivo</span>
                @endif
            </p>
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('facturas.edit', ['factura' => $item->id]) }}" class="btn btn-primary">Editar</a>
            @can('delete-records')
            <form action="{{ route('facturas.destroy', ['factura' => $item->id]) }}" method="POST" style="display:inline" class="confirm-delete">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection
