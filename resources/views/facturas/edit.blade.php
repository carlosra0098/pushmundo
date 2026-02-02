@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2>Editar Factura</h2>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('facturas.update', $item) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero', $item->numero) }}" required>
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ (old('cliente_id', $item->cliente_id) == $c->id) ? 'selected' : '' }}>
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
                    <input type="number" step="0.01" name="total" class="form-control @error('total') is-invalid @enderror" value="{{ old('total', $item->total) }}" required>
                    @error('total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', optional($item->fecha)->format('Y-m-d')) }}">
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror" value="{{ old('estado', $item->estado) }}">
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary">Actualizar</button>
                <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection