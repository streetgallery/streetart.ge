<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    @if(App::isLocale('ka'))
        @if(isset($configuration))
            <title>{{ $configuration->name }} @yield('title')</title>
        @else
            <title>{{ config('app.name', 'Street Art') }} @yield('title')</title>
        @endif
    @endif

    @if(App::isLocale('en'))
        @if(isset($configuration))
            <title>{{ $configuration->name_en }} @yield('title_en')</title>
        @else
            <title>{{ config('app.name', 'Street Art') }} @yield('title_en')</title>
        @endif
    @endif
    

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" >
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @if(session('alert_ok'))

    @endif

    @if(session('alert_fail'))

    @endif

    @yield('head')
</head>
<body>
@if(isset($configuration->bodystart))
    {!! $configuration->bodystart !!}
@endif
@yield('content')
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
@yield('bodyend')
</body>
</html>
