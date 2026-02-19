@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <h2>Editar Producto</h2>
        </div>
    </div>

    <div class="card crm-card mt-3">
        <div class="card-body">
            <form action="{{ route('productos.update', $item) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $item->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo', $item->codigo ?? '') }}">
                    @error('codigo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio', $item->precio ?? 0) }}" required>
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $item->stock ?? 0) }}">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Proveedor</label>
                    <select name="proveedor_id" class="form-control @error('proveedor_id') is-invalid @enderror">
                        <option value="">-</option>
                        @foreach($proveedores ?? [] as $id => $nombre)
                            <option value="{{ $id }}" {{ (old('proveedor_id', $item->proveedor_id ?? '') == $id) ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('proveedor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen del producto</label>
                    @if($item->imagen_url)
                        <div class="mb-2">
                            <img src="{{ $item->imagen_url }}" alt="Imagen actual" width="72" height="72" class="rounded object-fit-cover">
                        </div>
                    @endif
                    <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp,image/*">
                    @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ficha técnica (PDF)</label>
                    @if($item->archivo_pdf_url)
                        <div class="mb-2">
                            <a href="{{ $item->archivo_pdf_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">Ver PDF actual</a>
                        </div>
                    @endif
                    <input type="file" name="archivo_pdf" class="form-control @error('archivo_pdf') is-invalid @enderror" accept=".pdf,application/pdf">
                    @error('archivo_pdf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">Actualizar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection