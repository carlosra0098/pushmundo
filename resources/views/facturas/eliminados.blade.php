@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Facturas eliminadas</h1>
    <table class="table">
        <thead><tr><th>ID</th><th>Cliente</th><th>Fecha</th><th>Total</th><th></th></tr></thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ optional($item->cliente)->nombre }}</td>
                <td>{{ $item->fecha }}</td>
                <td>{{ $item->total }}</td>
                <td>
                    <form action="{{ route('facturas.restaurar', $item->id) }}" method="POST" style="display:inline" class="confirm-restore">@csrf<button class="btn btn-sm btn-success">Restaurar</button></form>
                    <form action="{{ route('facturas.forzar-eliminar', $item->id) }}" method="POST" style="display:inline" class="confirm-force">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Eliminar permanentemente</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
