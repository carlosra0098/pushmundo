@extends('layouts.app')

@section('plugins.Datatables', true)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Proveedores</h1>
        <a href="{{ route('proveedores.create') }}" class="btn btn-success">Nuevo Proveedor</a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <div class="card crm-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Contacto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->contacto }}</td>
                            <td>
                                <a href="{{ route('proveedores.show', ['proveedor' => $item->id]) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('proveedores.edit', ['proveedor' => $item->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                                @can('delete-records')
                                <form action="{{ route('proveedores.destroy', ['proveedor' => $item->id]) }}" method="POST" style="display:inline" class="confirm-delete">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay proveedores registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">{{ $items->links() }}</div>
</div>
@endsection

@push('js')
<script>
    $(function () {
        $('.table').DataTable({
            paging: false,
            info: false,
            lengthChange: false,
            language: {
                search: 'Buscar:',
                zeroRecords: 'No se encontraron coincidencias',
                infoEmpty: 'Sin registros disponibles'
            }
        });
    });
</script>
@endpush
