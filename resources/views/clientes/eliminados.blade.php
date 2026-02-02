@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-trash"></i> Clientes Eliminados
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Activos
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user"></i> Nombre Completo</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-phone"></i> Teléfono</th>
                            <th><i class="fas fa-calendar"></i> Eliminado el</th>
                            <th><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            <tr class="table-light">
                                <td class="fw-bold">{{ $cliente->id }}</td>
                                <td>
                                    <span class="text-muted text-decoration-line-through">{{ $cliente->nombre_completo }}</span>
                                </td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>
                                    <small class="text-muted">{{ $cliente->deleted_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('clientes.restaurar', $cliente->id) }}" 
                                              method="POST" 
                                              style="display:inline;">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-success" 
                                                    title="Restaurar cliente"
                                                    onclick="return confirm('¿Estás seguro de que deseas restaurar a {{ addslashes($cliente->nombre_completo) }}?')">
                                                <i class="fas fa-undo"></i> Restaurar
                                            </button>
                                        </form>
                                        <form action="{{ route('clientes.forzar-eliminar', $cliente->id) }}" 
                                              method="DELETE" 
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Eliminar permanentemente"
                                                    onclick="return confirm('⚠️ ADVERTENCIA: ¿Estás seguro de que deseas eliminar permanentemente a {{ addslashes($cliente->nombre_completo) }}? Esta acción no se puede deshacer.')">
                                                <i class="fas fa-trash"></i> Eliminar Permanentemente
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-inbox"></i> No hay clientes eliminados.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($clientes->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $clientes->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.04);
    }
    
    .btn-group {
        gap: 4px;
        display: flex;
    }
</style>
@endpush
@endsection