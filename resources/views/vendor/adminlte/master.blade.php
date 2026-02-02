<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- IFrame Preloader Removal Workaround --}}
    <!-- IFrame Preloader Removal Workaround -->
    <style type="text/css">
        body.iframe-mode .preloader {
            display: none !important;
        }
        
        /* CRMundo Custom Colors */
        html,
        body {
            background-color: #333c87 !important;
        }
        
        .wrapper {
            background-color: #333c87 !important;
        }
        
        .content-wrapper {
            background-color: #333c87 !important;
            min-height: 100vh;
        }
        
        /* Header/Navbar black */
        .main-header {
            background-color: #000000 !important;
            border-bottom-color: #1a1a1a !important;
        }
        
        .navbar {
            background-color: #000000 !important;
        }
        
        .navbar-white {
            background-color: #000000 !important;
        }
        
        .navbar-light {
            background-color: #000000 !important;
        }
        
        /* Sidebar black */
        .main-sidebar {
            background-color: #000000 !important;
            background: #000000 !important;
        }
        
        .sidebar {
            background-color: #000000 !important;
            background: #000000 !important;
        }
        
        .sidebar-dark {
            background-color: #000000 !important;
        }
        
        .sidebar-dark .nav-sidebar > .nav-item > .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .sidebar-dark .nav-sidebar > .nav-item > .nav-link:hover {
            color: rgba(255, 255, 255, 1) !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        .sidebar-dark .nav-sidebar > .nav-item.menu-open > .nav-link,
        .sidebar-dark .nav-sidebar > .nav-item > .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        /* Footer black */
        .main-footer {
            background-color: #000000 !important;
            border-top-color: #1a1a1a !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .main-footer a {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        /* Tables styling */
        .table {
            background-color: #1a1a2e !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .table thead th {
            background-color: #000000 !important;
            color: rgba(255, 255, 255, 1) !important;
            border-color: #1a1a1a !important;
        }
        
        .table tbody tr {
            border-color: #1a1a1a !important;
        }
        
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }
        
        .table tbody td {
            color: rgba(255, 255, 255, 0.9) !important;
            border-color: #1a1a1a !important;
        }
        
        /* Card styling */
        .card {
            background-color: #1a1a2e !important;
            border-color: #1a1a1a !important;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .card-header {
            background-color: #000000 !important;
            border-color: #1a1a1a !important;
            color: rgba(255, 255, 255, 1) !important;
        }
        
        .card-body {
            background-color: #1a1a2e !important;
        }
        
        /* Content header */
        .content-header {
            background-color: transparent !important;
        }
        
        .content-header .breadcrumb {
            background-color: transparent !important;
        }
        
        /* Form elements */
        .form-control,
        .form-select {
            background-color: #2a2a3e !important;
            color: rgba(255, 255, 255, 0.9) !important;
            border-color: #1a1a1a !important;
        }
        
        .form-control:focus,
        .form-select:focus {
            background-color: #333c50 !important;
            color: rgba(255, 255, 255, 1) !important;
            border-color: #333c87 !important;
            box-shadow: 0 0 0 0.2rem rgba(51, 60, 135, 0.25) !important;
        }
        
        /* Button styling */
        .btn-primary {
            background-color: #333c87 !important;
            border-color: #333c87 !important;
        }
        
        .btn-primary:hover {
            background-color: #2a3270 !important;
            border-color: #2a3270 !important;
        }
    </style>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets (depends on Laravel asset bundling tool) --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_css_path', 'css/app.css')) }}">
            @break

            @case('vite')
                @vite([config('adminlte.laravel_css_path', 'resources/css/app.css'), config('adminlte.laravel_js_path', 'resources/js/app.js')])
            @break

            @case('vite_js_only')
                @vite(config('adminlte.laravel_js_path', 'resources/js/app.js'))
            @break

            @default
                <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

                @if(config('adminlte.google_fonts.allowed', true))
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
                @endif
        @endswitch
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png') }}">
    @endif

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts (depends on Laravel asset bundling tool) --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <script src="{{ mix(config('adminlte.laravel_js_path', 'js/app.js')) }}"></script>
            @break

            @case('vite')
            @case('vite_js_only')
            @break

            @default
                <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
                <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
                <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        @endswitch
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

    {{-- Ensure preloader shows at least a minimum time so the GIF is visible --}}
    <script>
        (function(){
            var MIN_PRELOADER_MS = 1500; // minimum milliseconds to show preloader
            var pre = null;
            document.addEventListener('DOMContentLoaded', function(){
                pre = document.querySelector('.preloader');
                if(!pre) return;
                // record the time when DOM ready
                var start = Date.now();
                // On window load, ensure preloader remains visible at least MIN_PRELOADER_MS
                window.addEventListener('load', function(){
                    var elapsed = Date.now() - start;
                    var remaining = Math.max(0, MIN_PRELOADER_MS - elapsed);
                    setTimeout(function(){
                        try{
                            // fade out then remove
                            pre.style.transition = 'opacity 300ms ease';
                            pre.style.opacity = 0;
                            setTimeout(function(){ if(pre && pre.parentNode) pre.parentNode.removeChild(pre); }, 350);
                        }catch(e){
                            if(pre && pre.parentNode) pre.parentNode.removeChild(pre);
                        }
                    }, remaining);
                });
            });
        })();
    </script>

</body>

</html>
