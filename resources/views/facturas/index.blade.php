@extends('layouts.app')

@section('plugins.Datatables', true)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Facturas</h1>
        <a href="{{ route('facturas.create') }}" class="btn btn-success">Nueva Factura</a>
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
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>PDF</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ optional($item->cliente)->nombre ?? 'N/A' }}</td>
                            <td>{{ $item->fecha ?? '' }}</td>
                            <td>{{ number_format($item->total ?? 0,2) }}</td>
                            <td>
                                @if($item->archivo_pdf_url)
                                    <a href="{{ $item->archivo_pdf_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">Ver PDF</a>
                                @else
                                    <span class="text-muted">Sin PDF</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('facturas.show', ['factura' => $item->id]) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('facturas.edit', ['factura' => $item->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                                @can('delete-records')
                                <form action="{{ route('facturas.destroy', ['factura' => $item->id]) }}" method="POST" style="display:inline" class="confirm-delete">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay facturas registradas.</td>
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
