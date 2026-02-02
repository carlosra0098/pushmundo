@extends('adminlte::page')

@section('title', 'Mi perfil')

@section('content_header')
<h1>Mi perfil</h1>
@stop

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4 mb-3">
            {{-- Perfil rápido --}}
            <x-adminlte-profile-widget :name="$user->name" :desc="($user->email)" :img="$user->adminlte_image()" theme="primary" layoutType="modern" headerClass="bg-gradient-primary" />

            <div class="card crm-card mt-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Estadísticas</h5>
                    <div class="profile-stats">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="p-2 border rounded bg-dark">
                                    <div class="h4 mb-0">{{ $stats['clientes'] }}</div>
                                    <small class="text-muted">Clientes</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border rounded bg-dark">
                                    <div class="h4 mb-0">{{ $stats['productos'] }}</div>
                                    <small class="text-muted">Productos</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 border rounded bg-dark">
                                    <div class="h4 mb-0">{{ $stats['facturas'] }}</div>
                                    <small class="text-muted">Facturas</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
        {{-- Mensajes --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card crm-card">
            <div class="card-header d-flex align-items-center justify-content-between p-3">
                <ul class="nav nav-pills" role="tablist">
                    @php $active = session('active_tab') ?? old('active_tab') ?? 'info'; @endphp
                    <li class="nav-item"><a class="{{ $active === 'info' ? 'nav-link active' : 'nav-link' }}" id="tab-info" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="{{ $active === 'info' ? 'true' : 'false' }}">Información</a></li>
                    <li class="nav-item"><a class="{{ $active === 'ajustes' ? 'nav-link active' : 'nav-link' }}" id="tab-ajustes" data-bs-toggle="tab" href="#ajustes" role="tab" aria-controls="ajustes" aria-selected="{{ $active === 'ajustes' ? 'true' : 'false' }}">Ajustes</a></li>
                    <li class="nav-item"><a class="{{ $active === 'seguridad' ? 'nav-link active' : 'nav-link' }}" id="tab-seguridad" data-bs-toggle="tab" href="#seguridad" role="tab" aria-controls="seguridad" aria-selected="{{ $active === 'seguridad' ? 'true' : 'false' }}">Seguridad</a></li>
                    <li class="nav-item"><a class="{{ $active === 'actividad' ? 'nav-link active' : 'nav-link' }}" id="tab-actividad" data-bs-toggle="tab" href="#actividad" role="tab" aria-controls="actividad" aria-selected="{{ $active === 'actividad' ? 'true' : 'false' }}">Actividad</a></li>
                </ul>

                <div class="profile-actions">
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary me-2">Editar perfil</a>
                    <a href="#seguridad" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tab">Cambiar contraseña</a>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade crm-tab-pane {{ $active === 'info' ? 'show active' : '' }}" id="info" role="tabpanel" aria-labelledby="tab-info">
                        <h5>Información del usuario</h5>
                        <p><strong>Nombre:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Registrado:</strong> {{ optional($user->created_at)->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="tab-pane fade crm-tab-pane {{ $active === 'ajustes' ? 'show active' : '' }}" id="ajustes" role="tabpanel" aria-labelledby="tab-ajustes">
                        <h5>Ajustes de cuenta</h5>
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="active_tab" value="ajustes">

                            <div class="form-group mb-3">
                                <label for="name">Nombre</label>
                                <input id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>

                            <button class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>

                    <div class="tab-pane fade crm-tab-pane {{ $active === 'seguridad' ? 'show active' : '' }}" id="seguridad" role="tabpanel" aria-labelledby="tab-seguridad">
                        <h5>Cambiar contraseña</h5>
                        <form method="POST" action="{{ route('profile.password') }}">
                            @csrf
                            <input type="hidden" name="active_tab" value="seguridad">

                            <div class="form-group mb-3">
                                <label for="current_password">Contraseña actual</label>
                                <input id="current_password" name="current_password" type="password" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Nueva contraseña</label>
                                <input id="password" name="password" type="password" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation">Confirmar nueva contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                            </div>

                            <button class="btn btn-danger">Cambiar contraseña</button>
                        </form>
                    </div>

                    <div class="tab-pane fade crm-tab-pane {{ $active === 'actividad' ? 'show active' : '' }}" id="actividad" role="tabpanel" aria-labelledby="tab-actividad">
                        <h5>Actividad reciente</h5>
                        <div class="list-group profile-activity">
                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>Inicio de sesión</strong>
                                    <div class="small text-muted">{{ optional($user->last_login_at ?? $user->updated_at)->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="text-muted small">IP: 127.0.0.1</div>
                            </div>

                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>Actualizó perfil</strong>
                                    <div class="small text-muted">{{ optional($user->updated_at)->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="text-muted small">-</div>
                            </div>

                            <div class="list-group-item text-muted">Si quieres, puedo integrar un log de auditoría para esta sección.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@section('adminlte_js')
<script>
    // Tab fallback: ensure tab clicks and URL hash activate panes even if bootstrap data-* doesn't initialize
    (function(){
        function activateTabById(id){
            if(!id) return;
            document.querySelectorAll('.nav-pills .nav-link').forEach(function(link){ link.classList.remove('active'); link.setAttribute('aria-selected', 'false'); });
            document.querySelectorAll('.tab-content .tab-pane').forEach(function(pane){ pane.classList.remove('show','active'); });

            var link = document.querySelector('.nav-pills .nav-link[href="#'+id+'"]');
            var pane = document.getElementById(id);
            if(link) { link.classList.add('active'); link.setAttribute('aria-selected', 'true'); }
            if(pane) { pane.classList.add('show','active'); }
        }

        document.addEventListener('DOMContentLoaded', function(){
            var tabs = document.querySelectorAll('a[data-bs-toggle="tab"], a[data-toggle="tab"]');
            tabs.forEach(function(a){
                a.addEventListener('click', function(e){
                    e.preventDefault();
                    var target = (a.getAttribute('href') || '').replace('#','');
                    activateTabById(target);
                    try{ history.replaceState && history.replaceState(null, null, '#'+target); }catch(_){}
                });
            });

            if(location.hash){ activateTabById(location.hash.replace('#','')); }
        });

        window.activateTabById = activateTabById; // expose for tests
    })();
</script>
@stop
