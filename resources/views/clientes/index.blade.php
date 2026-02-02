@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-users"></i> Gestión de Clientes
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('clientes.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Cliente
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

    <div class="card shadow-sm crm-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user"></i> Nombre Completo</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-phone"></i> Teléfono</th>
                            <th><i class="fas fa-cogs"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            <tr>
                                <td class="fw-bold">{{ $cliente->id }}</td>
                                <td>{{ $cliente->nombre_completo }}</td>
                                <td>
                                    <a href="mailto:{{ $cliente->email }}">{{ $cliente->email }}</a>
                                </td>
                                <td>
                                    <a href="tel:{{ $cliente->telefono }}">{{ $cliente->telefono }}</a>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar cliente">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" 
                                              method="POST" 
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Eliminar cliente"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar a {{ addslashes($cliente->nombre_completo) }}?')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-inbox"></i> No hay clientes registrados aún.
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