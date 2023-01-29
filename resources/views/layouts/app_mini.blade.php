<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'NETPARK') }} @yield('title')</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    @if(App::isLocale('ka'))
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ka.css') }}">
    @endif
    @if(App::isLocale('en'))
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/en.css') }}">
    @endif
    @if(App::isLocale('ru'))
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ru.css') }}">
    @endif

<!-- Core JS files -->
    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @if(session('alert_ok'))
        <script src="{{ asset('global_assets/js/plugins/notifications/pnotify.min.js') }}"></script>
        <script type="text/javascript" >
            $(function() {
                var notice = new PNotify({

                    title: 'Notification',
                    text: '{{ session('alert_ok') }}',
                    addclass: 'centrinoti',
                    type: 'success',
                    delay: 3000,
                    hide: true,
                    buttons: {
                        closer: true,
                        sticker: false
                    }
                });
                notice.get().click(function() {
                    notice.remove();
                });
            });
        </script>
    @endif
    @if(session('alert_fail'))
        <script src="{{ asset('global_assets/js/plugins/notifications/pnotify.min.js') }}"></script>
        <script type="text/javascript" >
            $(function() {
                var notice = new PNotify({
                    title: 'Notification',
                    text: '{{ session('alert_fail') }}',
                    addclass: 'centrinoti',
                    type: 'danger',
                    delay: 500,
                    hide: true,
                    buttons: {
                        closer: true,
                        sticker: false
                    }
                });
                notice.get().click(function() {
                    notice.remove();
                });
            });
        </script>
    @endif
    <script type="text/javascript" >
        $(function() {
            $('body').on('click', '#sidebar-switcher', function(){

                @if(session()->has("sidebar") && session()->get('sidebar') == "sidebar-xs")

                $.post("{{ asset('admin/sidebar-switcher') }}", {sidebar: "sidebar-lg"} );

                @else

                $.post("{{ asset('admin/sidebar-switcher') }}", {sidebar: "sidebar-xs"} );

                @endif
            });

        });

    </script>
    @yield('head')

</head>
<body class=" @if(session()->has("sidebar") && session()->get('sidebar') == "sidebar-xs") sidebar-xs @else sidebar-lg  @endif  ">
    <div class="page-content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
@yield('bodyend')
</body>
</html>
