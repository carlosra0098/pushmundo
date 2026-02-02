@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Empleados eliminados</h1>
    <table class="table">
        <thead><tr><th>ID</th><th>Nombre</th><th>Puesto</th><th></th></tr></thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->puesto }}</td>
                <td>
                    <form action="{{ route('empleados.restaurar', $item->id) }}" method="POST" style="display:inline" class="confirm-restore">@csrf<button class="btn btn-sm btn-success">Restaurar</button></form>
                    <form action="{{ route('empleados.forzar-eliminar', $item->id) }}" method="POST" style="display:inline" class="confirm-force">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar permanentemente</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
