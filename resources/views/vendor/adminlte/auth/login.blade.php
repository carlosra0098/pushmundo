@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <style>
        /* Login CRM styling */
        body.login-page {
            background: linear-gradient(135deg, #1f2a63 0%, #333c87 50%, #1a1a2e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 900px;
            max-width: 95%;
        }

        .login-box .card {
            overflow: hidden;
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 30px rgba(0,0,0,0.45);
        }

        .login-left {
            background: url('{{ asset('img/corporate mundo.jpg') }}') no-repeat center/cover;
            min-height: 420px;
            color: #fff;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left .brand {
            backdrop-filter: blur(4px);
            background: rgba(0,0,0,0.25);
            padding: 12px 18px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .login-left p.lead {
            color: rgba(255,255,255,0.9);
            margin-bottom: 0;
            font-size: 1.05rem;
        }

        .login-right {
            padding: 36px 32px;
        }

        .login-right .card-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #333c87;
            margin-bottom: 0.75rem;
        }

        .login-right .form-control {
            border-radius: 6px;
        }

        .login-right .btn-primary {
            background-color: #333c87;
            border-color: #333c87;
            box-shadow: none;
        }

        .login-footer-note {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 12px;
        }

        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-box { width: 420px; }
        }
    </style>
@stop

@php
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');
    $registerUrl = View::getSection('register_url') ?? config('adminlte.register_url', 'register');
    $passResetUrl = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset');

    if (config('adminlte.use_route_url', false)) {
        $loginUrl = $loginUrl ? route($loginUrl) : '';
        $registerUrl = $registerUrl ? route($registerUrl) : '';
        $passResetUrl = $passResetUrl ? route($passResetUrl) : '';
    } else {
        $loginUrl = $loginUrl ? url($loginUrl) : '';
        $registerUrl = $registerUrl ? url($registerUrl) : '';
        $passResetUrl = $passResetUrl ? url($passResetUrl) : '';
    }
@endphp

@section('auth_header', 'Bienvenido a CRMundo')

@section('auth_body')
    <div class="row">
        <div class="col-md-6 login-left d-flex flex-column">
            <div class="brand">CRMundo</div>
            <p class="lead">Gestiona clientes, productos y facturas desde un panel claro y potente. Ingresa con tu usuario para continuar.</p>
        </div>

        <div class="col-md-6 login-right">
            <h3 class="card-title">Accede a tu cuenta</h3>

            <form action="{{ $loginUrl }}" method="post">
                @csrf

                {{-- Email field --}}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Password field --}}
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{ __('adminlte::adminlte.password') }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row mb-2">
                    <div class="col-7">
                        <div class="icheck-primary" title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label for="remember">
                                {{ __('adminlte::adminlte.remember_me') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-5">
                        <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                            <span class="fas fa-sign-in-alt"></span>
                            {{ __('adminlte::adminlte.sign_in') }}
                        </button>
                    </div>
                </div>

                <div class="login-footer-note">¿No tienes una cuenta? <a href="{{ $registerUrl }}">Regístrate</a> · <a href="{{ $passResetUrl }}">Recuperar contraseña</a></div>
            </form>
        </div>
    </div>
@stop

@section('auth_footer')
    {{-- Password reset link --}}
    @if($passResetUrl)
        <p class="my-0">
            <a href="{{ $passResetUrl }}">
                {{ __('adminlte::adminlte.i_forgot_my_password') }}
            </a>
        </p>
    @endif

    {{-- Register link --}}
    @if($registerUrl)
        <p class="my-0">
            <a href="{{ $registerUrl }}">
                {{ __('adminlte::adminlte.register_a_new_membership') }}
            </a>
        </p>
    @endif
@stop
