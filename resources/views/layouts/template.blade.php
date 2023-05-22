<!DOCTYPE html>
<html lang="es" class="dark-layout">

<head>
    {{-- Info --}}
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        @hasSection('page-title')
            @yield('page-title') -
            {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>
    {{-- Imports of css --}}
    @include('layouts.css-imports')
</head>

<body class="horizontal-layout horizontal-menu content-left-sidebar navbar-floating footer-static" data-open="hover"
    data-menu="horizontal-menu" data-col="content-left-sidebar">
    @include('layouts.header')
    @yield('app-content')
    @include('layouts.footer')
</body>
{{-- Imports of js --}}
@include('layouts.js-imports')

</html>
