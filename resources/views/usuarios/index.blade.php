@extends('layouts.app')

@section('plugins.Datatables', true)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Gestión de Roles de Usuarios</h1>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card crm-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol actual</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Administrador</span>
                                    @else
                                        <span class="badge bg-secondary">Usuario</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('usuarios.update-role', $user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="role" value="admin">
                                            <button class="btn btn-sm btn-outline-danger" {{ $user->role === 'admin' ? 'disabled' : '' }}>
                                                Hacer Admin
                                            </button>
                                        </form>

                                        <form action="{{ route('usuarios.update-role', $user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="role" value="usuario">
                                            <button class="btn btn-sm btn-outline-primary" {{ $user->role === 'usuario' ? 'disabled' : '' }}>
                                                Hacer Usuario
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">{{ $users->links() }}</div>
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
