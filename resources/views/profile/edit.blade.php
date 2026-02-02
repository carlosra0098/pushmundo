@extends('adminlte::page')

@section('title', 'Editar perfil')

@section('content_header')
<h1>Editar perfil</h1>
@stop

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card crm-card">
                <div class="card-header bg-gradient-primary text-white">Actualizar información</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" novalidate enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="active_tab" value="ajustes">

                        <div class="form-group mb-3">
                            <label for="name">Nombre</label>
                            <input id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="avatar">Avatar (opcional, imagen hasta 2MB)</label>
                            <input id="avatar" name="avatar" type="file" accept="image/*" class="form-control">
                            @if($user->avatar)
                                <div class="mt-2">
                                    <img src="{{ $user->adminlte_image() }}" alt="Avatar" class="img-thumbnail" style="width:90px;height:90px;object-fit:cover;">
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('profile') }}" class="btn btn-secondary">Cancelar</a>
                            <button class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>

                    <hr>

                    <h5 class="mt-3">Avatar</h5>
                    <p class="text-muted">Actualmente usamos Gravatar por defecto. Si quieres puedo integrar subida de avatar.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
