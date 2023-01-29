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

    @if(isset($configuration) && $configuration->site_off == 1 )
        @if( isset(Auth::user()->group_role) && Auth::user()->group_role == 'superAdmin'  )

        @else
            <meta http-equiv="refresh" content="0; url={{ asset('/off') }}">
            <script type="text/javascript">
                window.location.href = "{{ asset('/off') }}"
            </script>
        @endif
    @endif

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" >
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @yield('head')
</head>
<body class="@yield('body_class')">
@if(isset($configuration->bodystart))
    {!! $configuration->bodystart !!}
@endif
@yield('bodystart')

    <section class="header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="top-nav-street">
                        <div class="lang">
                            @if(App::isLocale('ka')) <a class="language " href="{{ asset('lang/en') }}">@lang('site.English')</a>  @endif
                            @if(App::isLocale('en')) <a class="language " href="{{ asset('lang/ka') }}">@lang('site.Georgian')</a>  @endif
                        </div>
                        <div class="logo">
                            <a href="{{ asset('') }}" >
                                @if(isset($configuration->logo))
                                    {!! $configuration->logo !!}
                                @endif
                            </a>
                        </div>
                        <div class="social">
                            @if(isset($contact->facebook))
                                <a target="_blank" href="{{ $contact->facebook }}">
                                    <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"/></svg>
                                </a>
                            @endif

                            @if(isset($contact->instagram))
                                <a target="_blank" href="{{ $contact->instagram }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" role="img" class="icon fill-current"><path d="M8 0C5.827 0 5.555.01 4.702.048 3.85.088 3.27.222 2.76.42c-.526.204-.973.478-1.417.923-.445.444-.72.89-.923 1.417-.198.51-.333 1.09-.372 1.942C.008 5.555 0 5.827 0 8s.01 2.445.048 3.298c.04.852.174 1.433.372 1.942.204.526.478.973.923 1.417.444.445.89.72 1.417.923.51.198 1.09.333 1.942.372.853.04 1.125.048 3.298.048s2.445-.01 3.298-.048c.852-.04 1.433-.174 1.942-.372.526-.204.973-.478 1.417-.923.445-.444.72-.89.923-1.417.198-.51.333-1.09.372-1.942.04-.853.048-1.125.048-3.298s-.01-2.445-.048-3.298c-.04-.852-.174-1.433-.372-1.942-.204-.526-.478-.973-.923-1.417-.444-.445-.89-.72-1.417-.923-.51-.198-1.09-.333-1.942-.372C10.445.008 10.173 0 8 0zm0 1.44c2.136 0 2.39.01 3.233.048.78.036 1.203.166 1.485.276.374.145.64.318.92.598.28.28.453.546.598.92.11.282.24.705.276 1.485.038.844.047 1.097.047 3.233s-.01 2.39-.048 3.233c-.036.78-.166 1.203-.276 1.485-.145.374-.318.64-.598.92-.28.28-.546.453-.92.598-.282.11-.705.24-1.485.276-.844.038-1.097.047-3.233.047s-2.39-.01-3.233-.048c-.78-.036-1.203-.166-1.485-.276-.374-.145-.64-.318-.92-.598-.28-.28-.453-.546-.598-.92-.11-.282-.24-.705-.276-1.485C1.45 10.39 1.44 10.136 1.44 8s.01-2.39.048-3.233c.036-.78.166-1.203.276-1.485.145-.374.318-.64.598-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276C5.61 1.45 5.864 1.44 8 1.44zm0 2.452c-2.27 0-4.108 1.84-4.108 4.108 0 2.27 1.84 4.108 4.108 4.108 2.27 0 4.108-1.84 4.108-4.108 0-2.27-1.84-4.108-4.108-4.108zm0 6.775c-1.473 0-2.667-1.194-2.667-2.667 0-1.473 1.194-2.667 2.667-2.667 1.473 0 2.667 1.194 2.667 2.667 0 1.473-1.194 2.667-2.667 2.667zm5.23-6.937c0 .53-.43.96-.96.96s-.96-.43-.96-.96.43-.96.96-.96.96.43.96.96z"></path></svg>
                                </a>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <section class="header-main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="nav-main-street">

                        <div class="menuin">
                            <div class="menu-burger">@lang('site.MENU')</div>
                            <div class="burgerbar" >
                                <div class="bar1"></div>
                                <div class="bar2"></div>
                                <div class="bar3"></div>
                            </div>
                        </div>


                        <div class="search-head flex-grow-1">
                            <form class="search-form" action="projects">
                                <div class="searchIcon">
                                    <svg viewBox="0 0 12 12"><path d="M11.407,10.421,8.818,7.832a4.276,4.276,0,1,0-.985.985l2.589,2.589a.7.7,0,0,0,.985-.985ZM2.355,5.352a3,3,0,1,1,3,3,3,3,0,0,1-3-3Z"></path></svg>
                                </div>
                                <input type="text" size="1" placeholder="@lang('site.Search...')" onfocus="this.placeholder = ''" onblur="this.placeholder = '@lang('site.Search...')'" name="search" autocomplete="off" class="form-control" id="search-main">
                                <div>
                                 </div>
                            </form>
                        </div>

                        @guest
                            <div class="item-login">
                                <span>@lang('site.Are you a member?')</span>
                                <a  class="text-black open_login" href="/login"><strong>@lang('site.Register / log in')</strong></a>
                            </div>
                        @endguest
                        @auth

                            <div class="user-nav ">

                                <div class="user_upload">
                                    <a href="{{ asset('add-project') }}" class="btn btn-upload"><span>@lang('site.UPLOAD')</span></a>
                                </div>

                                @if(isset(Auth::user()->images[0]->small))
                                    <a href="#user" class="user-avatar dropdown-toggle" data-toggle="dropdown">
                                        <img  src="{{ asset(Auth::user()->images[0]->small) }}"  />
                                    </a>
                                @else
                                    <a href="#user" class="user-svg dropdown-toggle" data-toggle="dropdown">
                                        <svg class="user-icon"  viewBox="0 0 64 64" fill="currentColor" tabindex="0" focusable="true" aria-labelledby="userIconTitle" role="img" style="outline: 0px;"><title id="userIconTitle">User Account</title><path fill-rule="evenodd" d="M32,59.7c-7.9,0-15.5-3.4-20.7-9.3c0.8-1.5,2-2.7,3.4-3.5c4.2-2.5,10.4-3.9,16.9-3.9s12.6,1.4,16.9,3.9 c1.7,0.9,3,2.3,3.6,4.1C47,56.5,39.6,59.7,32,59.7 M36.9,36.7c-5.1,2.9-11.6,1.1-14.5-4c-1.8-3.3-1.8-7.2,0-10.4 c0.9-1.7,2.3-3.3,4.1-4.1c5.2-2.8,11.7-0.9,14.5,4.3c1.7,3.1,1.7,7.1,0,10.2C40,34.4,38.6,35.8,36.9,36.7 M42.3,6.2 c7.5,2.7,13.3,8.8,15.8,16.3c2.9,8.2,1.8,17.5-3,24.8c-1.1-1.7-2.6-3.1-4.3-4.1c-3.3-1.8-6.8-3-10.5-3.7c4.9-3.4,7.3-9.3,6.1-15.2 c-1.2-6-6-10.5-11.9-11.5c-8-1.5-15.8,3.7-17.4,11.7c-1.1,5.9,1.3,11.7,6.2,15.1c-3.7,0.7-7.4,1.8-10.6,3.7 c-1.5,0.9-2.9,2.1-3.9,3.5C5.7,42.3,4.3,37.2,4.3,32C4.3,13.5,22.8-1,42.3,6.2 M42.6,1.8C25.9-4,7.6,4.8,1.8,21.5 c-2.4,6.8-2.4,14.3,0,21.2c3,9.2,10.3,16.5,19.5,19.5c16.7,5.9,35-2.9,40.9-19.7c2.4-6.8,2.4-14.3,0-21.2 C59.2,12.1,52,4.9,42.6,1.8"></path></svg>
                                    </a>
                                @endif

                                <div class="dropdown-menu tooltip-user dropdown-menu-right">
                                    <div class="triangle"></div>
                                    <ul class="profile-drop">
                                        <li><a href="{{ asset('account/profile') }}" class="@if(isset($menu) && $menu == 'profile') active @endif ">@lang('site.Edit Profile')</a></li>
                                        <li><a href="{{ asset('account/avatar') }}" class="@if(isset($menu) && $menu == 'avatar') active @endif ">@lang('site.Avatar')</a></li>
                                        <li><a href="{{ asset('account/social_profiles') }}" class="@if(isset($menu) && $menu == 'social_profiles') active @endif">@lang('site.Social Profiles')</a></li>
                                        <li><a href="{{ asset('account/password') }}" class="@if(isset($menu) && $menu == 'password') active @endif">@lang('site.Password')</a></li>
                                        <li><a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('site.Sign Out')</a></li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>

                            </div>

                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(session('alert_ok'))
        <div class="notice success">
            <h1>{{ session('alert_ok') }}</h1>
        </div>

    @endif

    @if(session('alert_fail'))
        <div class="notice">
            <h1>{{ session('alert_fail') }}</h1>
        </div>
    @endif

    @yield('content')

    <section class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer-box">
                        <div class="footer-copyright w-100">
                            <a href="http://eredeli.com/"  target="_blank" class="eredeli"></a>
                            <a href="http://eredeli.com/" class=" " target="_blank">Eredeli & Future Connetions</a>
                        </div>

                        <div class="w-100 copyright">© 2020 Artup. All rights reserved.</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="navigation-footer" >
                        <ul>
                            @if(isset($bottom_nav) && $bottom_nav->isNotEmpty()  )
                                @foreach($bottom_nav as $each)
                                    <li>
                                        <a @if(isset($each->link)) href="{{ asset($each->link) }}" @endif>
                                            @if(App::isLocale('ka'))<span>{{ $each->name }} </span>@endif
                                            @if(App::isLocale('en'))<span>{{ $each->name_en }} </span>@endif
                                        </a>
                                        @if(isset($each->parent) && $each->parent->isNotEmpty() )
                                            <ul>
                                                @foreach ($each->parent as $subeach)
                                                    <li>
                                                        <a href="{{ asset($subeach->link) }}">
                                                            @if(App::isLocale('ka')){{ $subeach->name }}@endif
                                                            @if(App::isLocale('en')){{ $subeach->name_en }}@endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="connect-box">
                        <h1>@lang('site.Connect')</h1>
                        <form method="post" action="{{ asset('subscribe') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-8">
                                    <input type="email" placeholder="@lang('site.Join our feed list')" class="form-control"  onfocus="this.placeholder = ''" onblur="this.placeholder = '@lang('site.Join our feed list')'" required >
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-location w-100">@lang('site.Subscribe')</button>
                                </div>
                            </div>
                        </form>

                        <ul>
                            @if(isset($contact->facebook))
                                <li>
                                    <a class="facebook" target="_blank" href="{{ $contact->facebook }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 24 24" class="icon fill-current"><title>Facebook icon</title><path d="M22.676 0H1.324C.593 0 0 .593 0 1.324v21.352C0 23.408.593 24 1.324 24h11.494v-9.294H9.689v-3.621h3.129V8.41c0-3.099 1.894-4.785 4.659-4.785 1.325 0 2.464.097 2.796.141v3.24h-1.921c-1.5 0-1.792.721-1.792 1.771v2.311h3.584l-.465 3.63H16.56V24h6.115c.733 0 1.325-.592 1.325-1.324V1.324C24 .593 23.408 0 22.676 0"></path></svg>
                                    </a>
                                </li>
                            @endif
                            @if(isset($contact->instagram))
                                <li>
                                    <a class="instagram" target="_blank" href="{{ $contact->instagram }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" role="img" class="icon fill-current"><path d="M8 0C5.827 0 5.555.01 4.702.048 3.85.088 3.27.222 2.76.42c-.526.204-.973.478-1.417.923-.445.444-.72.89-.923 1.417-.198.51-.333 1.09-.372 1.942C.008 5.555 0 5.827 0 8s.01 2.445.048 3.298c.04.852.174 1.433.372 1.942.204.526.478.973.923 1.417.444.445.89.72 1.417.923.51.198 1.09.333 1.942.372.853.04 1.125.048 3.298.048s2.445-.01 3.298-.048c.852-.04 1.433-.174 1.942-.372.526-.204.973-.478 1.417-.923.445-.444.72-.89.923-1.417.198-.51.333-1.09.372-1.942.04-.853.048-1.125.048-3.298s-.01-2.445-.048-3.298c-.04-.852-.174-1.433-.372-1.942-.204-.526-.478-.973-.923-1.417-.444-.445-.89-.72-1.417-.923-.51-.198-1.09-.333-1.942-.372C10.445.008 10.173 0 8 0zm0 1.44c2.136 0 2.39.01 3.233.048.78.036 1.203.166 1.485.276.374.145.64.318.92.598.28.28.453.546.598.92.11.282.24.705.276 1.485.038.844.047 1.097.047 3.233s-.01 2.39-.048 3.233c-.036.78-.166 1.203-.276 1.485-.145.374-.318.64-.598.92-.28.28-.546.453-.92.598-.282.11-.705.24-1.485.276-.844.038-1.097.047-3.233.047s-2.39-.01-3.233-.048c-.78-.036-1.203-.166-1.485-.276-.374-.145-.64-.318-.92-.598-.28-.28-.453-.546-.598-.92-.11-.282-.24-.705-.276-1.485C1.45 10.39 1.44 10.136 1.44 8s.01-2.39.048-3.233c.036-.78.166-1.203.276-1.485.145-.374.318-.64.598-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276C5.61 1.45 5.864 1.44 8 1.44zm0 2.452c-2.27 0-4.108 1.84-4.108 4.108 0 2.27 1.84 4.108 4.108 4.108 2.27 0 4.108-1.84 4.108-4.108 0-2.27-1.84-4.108-4.108-4.108zm0 6.775c-1.473 0-2.667-1.194-2.667-2.667 0-1.473 1.194-2.667 2.667-2.667 1.473 0 2.667 1.194 2.667 2.667 0 1.473-1.194 2.667-2.667 2.667zm5.23-6.937c0 .53-.43.96-.96.96s-.96-.43-.96-.96.43-.96.96-.96.96.43.96.96z"></path></svg>
                                    </a>
                                </li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="overlay" ></div>
    <section class="sidebar">

        <div class="header-sidebar">
            <div class="pull-right">
                <div class="bt-close js-close-menu text-uppercase">@lang('site.close')</div>
            </div>
        </div>


        <div id="menu">
            @if(isset($main_nav) && $main_nav->isNotEmpty()  )
                <ul class="list-group list-group-ai">
                    @foreach($main_nav as $each)
                        <li class="  list-group-item @if(isset($menu) && ("/" . str_replace( asset(""), '', url()->full()) == $each->link  || ($menu == "home" && $each->link == "/")  )) active @endif">
                            <a @if(isset($each->link)) href="{{ asset($each->link) }}" @endif>
                                @if(App::isLocale('ka'))<span>{{ $each->name }} </span>@endif
                                @if(App::isLocale('en'))<span>{{ $each->name_en }} </span>@endif
                            </a>
                            @if(isset($each->parent) && $each->parent->isNotEmpty() )
                                <ul>
                                    @foreach ($each->parent as $subeach)
                                        <li class="  @if(isset($menu) && ("/" . str_replace( asset(""), '', url()->full()) == $each->link  || ($menu == "home" && $each->link == "/")  )) active @endif">
                                            <a href="{{ asset($subeach->link) }}">
                                                @if(App::isLocale('ka')){{ $subeach->name }}@endif
                                                @if(App::isLocale('en')){{ $subeach->name_en }}@endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>

    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sliding-menu-'.  str_replace('_', '-', app()->getLocale()) .'.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('bodyend')
</body>
</html>
