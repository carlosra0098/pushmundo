@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card crm-card">
        <div class="card-body">
            <h1>Proveedores eliminados</h1>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>ID</th><th>Nombre</th><th>Contacto</th><th></th></tr></thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->contacto }}</td>
                            <td>
                                <form action="{{ route('proveedores.restaurar', $item->id) }}" method="POST" style="display:inline" class="confirm-restore">@csrf<button class="btn btn-sm btn-success">Restaurar</button></form>
                                <form action="{{ route('proveedores.forzar-eliminar', $item->id) }}" method="POST" style="display:inline" class="confirm-force">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar permanentemente</button></form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
