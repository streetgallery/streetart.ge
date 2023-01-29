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

@auth

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-light">

        <!-- Header with logos -->
        <div class="navbar-header navbar-dark d-none d-md-flex align-items-md-center">
            <div class="navbar-brand navbar-brand-md">
                <a href="{{ url('admin') }}" class="d-inline-block">
                    NETPARK
                    <img src="{{ asset('global_assets/images/logo.png') }}" alt="">
                </a>
            </div>

            <div class="navbar-brand navbar-brand-xs">
                <a href="{{ url('admin') }}" class="d-inline-block">
                    <img src="{{ asset('global_assets/images/logo_icon_light.png') }}" alt="">
                </a>
            </div>
        </div>
        <!-- /header with logos -->

        <!-- Mobile controls -->
        <div class="d-flex flex-1 d-md-none">
            <div class="navbar-brand mr-auto">
                <a href="{{ url('admin') }}" class="d-inline-block">
                    <img src="{{ asset('global_assets/images/logo.png') }}" alt="">
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>


            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>
        <!-- /mobile controls -->

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="navbar-nav mr-md-auto">
                <li class="nav-item">
                    <a href="#" id="sidebar-switcher" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                        <i class="icon-paragraph-justify3"></i>
                    </a>
                </li>
            </ul>


            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">

                        @if(App::isLocale('ka'))
                            <img src="{{ asset('global_assets/images/lang/ka.png') }}" class="img-flag mr-2" alt="">
                            ქართული
                        @endif
                        @if(App::isLocale('en'))
                            <img src="{{ asset('global_assets/images/lang/en.png') }}" class="img-flag mr-2" alt="">
                            English
                        @endif

                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ asset('lang/en') }}" class="dropdown-item english @if(App::isLocale('en')) active @endif"><img src="{{ asset('global_assets/images/lang/en.png') }}" class="img-flag" alt=""> English</a>
                        <a href="{{ asset('lang/ka') }}" class="dropdown-item georgian @if(App::isLocale('ka')) active @endif"><img src="{{ asset('global_assets/images/lang/ka.png') }}" class="img-flag" alt=""> ქართული</a>
                    </div>
                </li>


                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                        <span>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a target="_blank" href="{{ asset('')}}" class="dropdown-item"><i class="icon-eye"></i> საიტზე გადასვლა</a>
                        <a href="{{ asset('admin/users/update/'. Auth::user()->id)}}" class="dropdown-item"><i class="icon-cog5"></i> @lang('app.Account_settings')</a>
                        <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item"><i class="icon-switch2"></i> @lang('app.Logout')</a>
                    </div>
                </li>

            </ul>

        </div>
        <!--/navbar content -->

    </div>
    <!-- /main navbar -->

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

@endauth

<!-- Page content -->
<div class="page-content ">

    @auth
        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

            <!-- Sidebar mobile toggler -->
            <div class="sidebar-mobile-toggler text-center">
                <a href="#" class="sidebar-mobile-main-toggle">
                    <i class="icon-arrow-left8"></i>
                </a>
                Navigation
                <a href="#" class="sidebar-mobile-expand">
                    <i class="icon-screen-full"></i>
                    <i class="icon-screen-normal"></i>
                </a>
            </div>
            <!-- /sidebar mobile toggler -->


            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- User menu-->
                <div class="sidebar-user">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                                <div class="font-size-xs opacity-50">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/user menu -->

                <!-- Main navigation -->
                <div class="card card-sidebar-mobile">
                    <ul class="nav nav-sidebar" data-nav-type="accordion">
                        <li class="nav-item"><a href="{{ asset('admin/') }}" class="nav-link @if($menu == "home") active @endif"><i class="icon-home4"></i><span>@lang('app.Main') </span></a></li>

                        <li class="nav-item nav-item-submenu @if($menu == "articles" || $menu == "categories") nav-item-expanded nav-item-open @endif ">
                            <a href="#" class="nav-link"><i class="icon-file-text2"></i> <span>@lang('app.Articles')</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="@lang('app.Articles')">
                                <li class="nav-item"><a href="{{ asset('admin/articles') }}" class="nav-link @if($menu == "articles") active @endif">@lang('app.Articles')</a></li>
                                <li class="nav-item"><a href="{{ asset('admin/articles/categories') }}" class="nav-link @if($menu == "categories") active @endif">@lang('app.Categories')</a></li>
                             </ul>
                        </li>
                        

                        <li class="nav-item nav-item-submenu @if($menu == "projects" || $menu == "productCategories") nav-item-expanded nav-item-open @endif ">
                            <a href="#" class="nav-link"><i class="icon-bag"></i> <span>@lang('app.Projects')</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="@lang('app.Projects')">
                                <li class="nav-item"><a href="{{ asset('admin/projects') }}" class="nav-link @if($menu == "projects") active @endif">@lang('app.Projects')</a></li>
                                <li class="nav-item"><a href="{{ asset('admin/projects/categories') }}" class="nav-link @if($menu == "productCategories") active @endif">@lang('app.Categories')</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a href="{{ asset('admin/events') }}" class="nav-link @if($menu == "events") active @endif"><i class="icon-calendar3"></i><span>@lang('app.Events') </span></a></li>

                        <li class="nav-item nav-item-submenu @if($menu == "locations" || $menu == "countries" || $menu == "states" || $menu == "cities") nav-item-expanded nav-item-open @endif ">
                            <a href="#" class="nav-link"><i class="icon-location4"></i> <span>@lang('app.Locations')</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="@lang('app.Locations')">
                                <li class="nav-item"><a href="{{ asset('admin/countries') }}" class="nav-link @if($menu == "countries") active @endif">@lang('app.Countries')</a></li>
                                <li class="nav-item"><a href="{{ asset('admin/states') }}" class="nav-link @if($menu == "states") active @endif">@lang('app.States')</a></li>
                                <li class="nav-item"><a href="{{ asset('admin/cities') }}" class="nav-link @if($menu == "cities") active @endif">@lang('app.Cities')</a></li>
                                <li class="nav-item"><a href="{{ asset('admin/locations') }}" class="nav-link @if($menu == "locations") active @endif">@lang('app.Locations')</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a href="{{ asset('admin/exhibitions') }}" class="nav-link @if($menu == "exhibitions") active @endif"><i class="icon-stack-picture"></i><span>@lang('app.Exhibitions') </span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/navigation') }}" class="nav-link @if($menu == "navigation") active @endif"><i class="icon-paragraph-justify3"></i><span>@lang('app.Navigation') </span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/slides') }}" class="nav-link @if($menu == "slides") active @endif"><i class="icon-stack-picture"></i><span>@lang('app.Slides') </span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/banners') }}" class="nav-link @if($menu == "banners") active @endif"><i class="icon-stack-picture"></i><span>@lang('app.Banners') </span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/transactions') }}" class="nav-link @if($menu == "transactions") active @endif"><i class="icon-coin-dollar"></i><span>@lang('app.Transactions')</span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/logs') }}" class="nav-link @if($menu == "logs") active @endif"><i class="icon-tree5"></i><span>@lang('app.Logs')</span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/groups') }}" class="nav-link @if($menu == "groups") active @endif"><i class="icon-make-group"></i><span>@lang('app.Groups') </span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/users') }}" class="nav-link @if($menu == "users") active @endif"><i class="icon-user"></i><span>@lang('app.Users')</span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/subscribers') }}" class="nav-link @if($menu == "subscribers") active @endif"><i class="icon-mention"></i><span>@lang('app.Subscribers')</span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/configuration') }}" class="nav-link @if($menu == "configuration") active @endif"><i class="icon-cog3"></i><span>@lang('app.Configuration')</span></a></li>
                        <li class="nav-item"><a href="{{ asset('admin/contact') }}" class="nav-link @if($menu == "contact") active @endif"><i class="icon-pin-alt"></i><span>@lang('app.Contact')</span></a></li>
                        <li class="nav-item"><a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="icon-switch2"></i><span>@lang('app.Logout')</span></a></li>
                    </ul>
                </div>
                <!-- /main navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->
    @endauth

    <!-- Main content -->
    <div class="content-wrapper">

        @yield('content')


        @auth
            <!-- Footer -->
            <div class="navbar navbar-expand-lg navbar-light">
                <span class="navbar-text"> &copy; 2020. {{ config('app.name', 'ISP NETPARK') }} </span>
            </div>
            <!-- /footer -->
        @endauth

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->
@yield('bodyend')
</body>
</html>
