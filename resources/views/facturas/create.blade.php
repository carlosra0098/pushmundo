@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2>Nueva Factura</h2>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('facturas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero') }}" required>
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ old('cliente_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }} {{ $c->apellido ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <input type="number" step="0.01" name="total" class="form-control @error('total') is-invalid @enderror" value="{{ old('total', 0) }}" required>
                    @error('total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}">
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror" value="{{ old('estado', 'pendiente') }}">
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">PDF de la factura</label>
                    <input type="file" name="archivo_pdf" class="form-control @error('archivo_pdf') is-invalid @enderror" accept=".pdf,application/pdf">
                    @error('archivo_pdf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary">Guardar</button>
                <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection