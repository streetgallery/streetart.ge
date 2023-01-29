@extends('layouts.site')


@section('head')

    <meta property="og:url" content="{{ asset('artist') }}/{{ $artist->id }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="artup" />
    <meta property="article:publisher" content="artup" />

    @if(App::isLocale('ka'))

        @if(isset($artist->about))
            <meta name="description" content="{{ $artist->about }}">
        @endif

        @if(isset($artist->firstname))
            <meta name="keywords" content="@if(isset($artist->username)) {{ $artist->username }} @else {{ $artist->firstname }} {{ $artist->lastname }} @endif">
        @endif

        @if(isset($artist->firstname))
            <meta property="og:title" content="@if(isset($artist->username)) {{ $artist->username }} @else {{ $artist->firstname }} {{ $artist->lastname }} @endif" />
        @endif

        @if(isset($artist->about))
            <meta property="og:description" content="{{ $artist->about }}" />
        @endif

    @endif
    @if(App::isLocale('en'))

        @if(isset($artist->about_en))
            <meta name="description" content="{{ $artist->about_en }}">
        @endif

        @if(isset($artist->firstname_en))
            <meta name="keywords" content="@if(isset($artist->username_en)) {{ $artist->username_en }} @else {{ $artist->firstname_en }} {{ $artist->lastname_en }} @endif">
        @endif

        @if(isset($artist->firstname_en))
            <meta property="og:title" content="@if(isset($artist->username_en)) {{ $artist->username_en }} @else {{ $artist->firstname_en }} {{ $artist->lastname_en }} @endif" />
        @endif

        @if(isset($artist->about_en))
            <meta property="og:description" content="{{ $artist->about_en }}" />
        @endif
    @endif

    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="620" />
    <meta property="og:image:height" content="541" />

    @if(isset($artist->images[0]->medium))
        <meta property="og:image" content="{{ asset($artist->images[0]->medium) }}" />
    @endif




@endsection

@section('content')

    <section class="arist-header-section" style="background-color: {{ $artist->bg_color }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="artist-single">

                        @if(isset($artist->images[0]->medium))
                            <div class="artist-avatar">
                                <img src="{{ asset($artist->images[0]->medium) }}"  alt="">
                            </div>
                        @endif


                        @if(isset($artist))
                            <div class="artist-about">

                                <div class="artist-nickname">
                                    <span>@lang('site.Artist'):</span>

                                    @if(App::isLocale('ka'))
                                        @if(isset($artist->username))
                                             {{ $artist->username }}
                                        @else
                                            {{ $artist->firstname }} {{ $artist->lastname }}
                                        @endif
                                    @endif

                                    @if(App::isLocale('en'))
                                        @if(isset($artist->username_en))
                                            {{ $artist->username_en }}
                                        @else
                                            {{ $artist->firstname_en }} {{ $artist->lastname_en }}
                                        @endif
                                    @endif
                                </div>

                                <div class="bio">
                                    <span>@lang('site.Bio_Artist'):</span>
                                    {{ $artist->about }}
                                    @if(App::isLocale('ka'))
                                        {{ $artist->about }}
                                    @endif
                                    @if(App::isLocale('en'))
                                        {{ $artist->about_en }}
                                    @endif
                                </div>



                            @if(isset($artist->city) || isset($artist->city))
                                    <div class="artist-location">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-4808 -20688 14.286 20" class="Profile-locationIcon-2q2"><g><path d="M-4800.857-20688a7.143 7.143 0 0 0-7.143 7.143c0 5.714 7.143 12.857 7.143 12.857s7.143-7.143 7.143-12.857a7.142 7.142 0 0 0-7.143-7.143zm0 10a2.857 2.857 0 1 1 2.857-2.859 2.858 2.858 0 0 1-2.857 2.859z"></path></g></svg>
                                        @if(isset($artist->country))
                                            {{ $artist->country->name_en }}
                                        @endif
                                        -
                                        @if(isset($artist->city))
                                            {{ $artist->city->name_en }}
                                        @endif
                                    </div>
                                @endif

                                <div class="share-art mt-4">
                                    <span>@lang('site.Share'):</span>
                                    <ul>
                                        <li>
                                            <a class="facebook" target="_blank" href="{{ asset('artist/'. $artist->id ) }}" onclick="share();">
                                                <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"></path></svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <ul class="list-bts">
                                        @if(isset($artist->website))
                                            <li>
                                                <a href="{{ $artist->website }}" target="_blank">
                                                    <svg id="Layer_1" enable-background="new 0 0 512.418 512.418" height="512" viewBox="0 0 512.418 512.418" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m437.335 75.082c-100.1-100.102-262.136-100.118-362.252 0-100.103 100.102-100.118 262.136 0 362.253 100.1 100.102 262.136 100.117 362.252 0 100.103-100.102 100.117-262.136 0-362.253zm-10.706 325.739c-11.968-10.702-24.77-20.173-38.264-28.335 8.919-30.809 14.203-64.712 15.452-99.954h75.309c-3.405 47.503-21.657 92.064-52.497 128.289zm-393.338-128.289h75.309c1.249 35.242 6.533 69.145 15.452 99.954-13.494 8.162-26.296 17.633-38.264 28.335-30.84-36.225-49.091-80.786-52.497-128.289zm52.498-160.936c11.968 10.702 24.77 20.173 38.264 28.335-8.919 30.809-14.203 64.712-15.452 99.954h-75.31c3.406-47.502 21.657-92.063 52.498-128.289zm154.097 31.709c-26.622-1.904-52.291-8.461-76.088-19.278 13.84-35.639 39.354-78.384 76.088-88.977zm0 32.708v63.873h-98.625c1.13-29.812 5.354-58.439 12.379-84.632 27.043 11.822 56.127 18.882 86.246 20.759zm0 96.519v63.873c-30.119 1.877-59.203 8.937-86.246 20.759-7.025-26.193-11.249-54.82-12.379-84.632zm0 96.581v108.254c-36.732-10.593-62.246-53.333-76.088-88.976 23.797-10.817 49.466-17.374 76.088-19.278zm32.646 0c26.622 1.904 52.291 8.461 76.088 19.278-13.841 35.64-39.354 78.383-76.088 88.976zm0-32.708v-63.873h98.625c-1.13 29.812-5.354 58.439-12.379 84.632-27.043-11.822-56.127-18.882-86.246-20.759zm0-96.519v-63.873c30.119-1.877 59.203-8.937 86.246-20.759 7.025 26.193 11.249 54.82 12.379 84.632zm0-96.581v-108.254c36.734 10.593 62.248 53.338 76.088 88.977-23.797 10.816-49.466 17.373-76.088 19.277zm73.32-91.957c20.895 9.15 40.389 21.557 57.864 36.951-8.318 7.334-17.095 13.984-26.26 19.931-8.139-20.152-18.536-39.736-31.604-56.882zm-210.891 56.882c-9.165-5.947-17.941-12.597-26.26-19.931 17.475-15.394 36.969-27.801 57.864-36.951-13.068 17.148-23.465 36.732-31.604 56.882zm.001 295.958c8.138 20.151 18.537 39.736 31.604 56.882-20.895-9.15-40.389-21.557-57.864-36.951 8.318-7.334 17.095-13.984 26.26-19.931zm242.494 0c9.165 5.947 17.942 12.597 26.26 19.93-17.475 15.394-36.969 27.801-57.864 36.951 13.067-17.144 23.465-36.729 31.604-56.881zm26.362-164.302c-1.249-35.242-6.533-69.146-15.452-99.954 13.494-8.162 26.295-17.633 38.264-28.335 30.84 36.225 49.091 80.786 52.497 128.289z"/></svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if(isset($artist->facebook))
                                            <li>
                                                <a href="{{ $artist->facebook }}" target="_blank">
                                                    <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"/></svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if(isset($artist->instagram))
                                            <li>
                                                <a href="{{ $artist->instagram }}" target="_blank" >
                                                    <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m12.004 5.838c-3.403 0-6.158 2.758-6.158 6.158 0 3.403 2.758 6.158 6.158 6.158 3.403 0 6.158-2.758 6.158-6.158 0-3.403-2.758-6.158-6.158-6.158zm0 10.155c-2.209 0-3.997-1.789-3.997-3.997s1.789-3.997 3.997-3.997 3.997 1.789 3.997 3.997c.001 2.208-1.788 3.997-3.997 3.997z"/><path d="m16.948.076c-2.208-.103-7.677-.098-9.887 0-1.942.091-3.655.56-5.036 1.941-2.308 2.308-2.013 5.418-2.013 9.979 0 4.668-.26 7.706 2.013 9.979 2.317 2.316 5.472 2.013 9.979 2.013 4.624 0 6.22.003 7.855-.63 2.223-.863 3.901-2.85 4.065-6.419.104-2.209.098-7.677 0-9.887-.198-4.213-2.459-6.768-6.976-6.976zm3.495 20.372c-1.513 1.513-3.612 1.378-8.468 1.378-5 0-7.005.074-8.468-1.393-1.685-1.677-1.38-4.37-1.38-8.453 0-5.525-.567-9.504 4.978-9.788 1.274-.045 1.649-.06 4.856-.06l.045.03c5.329 0 9.51-.558 9.761 4.986.057 1.265.07 1.645.07 4.847-.001 4.942.093 6.959-1.394 8.453z"/><circle cx="18.406" cy="5.595" r="1.439"/></svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if(isset($artist->behance))
                                            <li>
                                                <a href="{{ $artist->behance }}" target="_blank" >
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 511.958 511.958" style="enable-background:new 0 0 511.958 511.958;" xml:space="preserve"><g><g><g><path d="M210.624,240.619c10.624-5.344,18.656-11.296,24.16-17.728c9.792-11.584,14.624-26.944,14.624-45.984 c0-18.528-4.832-34.368-14.496-47.648c-16.128-21.632-43.424-32.704-82.016-33.28H0v312.096h142.56 c16.064,0,30.944-1.376,44.704-4.192c13.76-2.848,25.664-8.064,35.744-15.68c8.96-6.624,16.448-14.848,22.4-24.544 c9.408-14.656,14.112-31.264,14.112-49.76c0-17.92-4.128-33.184-12.32-45.728C238.912,255.627,226.752,246.443,210.624,240.619z  M63.072,150.187h68.864c15.136,0,27.616,1.632,37.408,4.864c11.328,4.704,16.992,14.272,16.992,28.864 c0,13.088-4.32,22.24-12.864,27.392c-8.608,5.152-19.776,7.744-33.472,7.744H63.072V150.187z M171.968,348.427 c-7.616,3.68-18.336,5.504-32.064,5.504H63.072v-83.232h77.888c13.568,0.096,24.128,1.888,31.68,5.248 c13.44,6.08,20.128,17.216,20.128,33.504C192.768,328.651,185.856,341.579,171.968,348.427z"/><rect x="327.168" y="110.539" width="135.584" height="38.848"/><path d="M509.856,263.851c-2.816-18.08-9.024-33.984-18.688-47.712c-10.592-15.552-24.032-26.944-40.384-34.144 c-16.288-7.232-34.624-10.848-55.04-10.816c-34.272,0-62.112,10.72-83.648,32c-21.472,21.344-32.224,52.032-32.224,92.032 c0,42.656,11.872,73.472,35.744,92.384c23.776,18.944,51.232,28.384,82.4,28.384c37.728,0,67.072-11.232,88.032-33.632 	c13.408-14.144,20.992-28.064,22.656-41.728H446.24c-3.616,6.752-7.808,12.032-12.608,15.872 c-8.704,7.04-20.032,10.56-33.92,10.56c-13.216,0-24.416-2.912-33.76-8.704c-15.424-9.28-23.488-25.536-24.512-48.672h170.464 C512.16,289.739,511.52,274.411,509.856,263.851z M342.976,269.835c2.24-15.008,7.68-26.912,16.32-35.712 c8.64-8.768,20.864-13.184,36.512-13.216c14.432,0,26.496,4.128,36.32,12.416c9.696,8.352,15.168,20.48,16.288,36.512H342.976z" /></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if(isset($artist->dribbble))
                                            <li>
                                                <a href="{{ $artist->dribbble }}" target="_blank" >
                                                    <svg id="regular" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m16.354 23.17c.02-.006.039-.014.059-.021 12.215-4.853 8.836-23.149-4.413-23.149-6.649 0-12 5.42-12 12 0 8.327 8.434 14.269 16.354 11.17zm-11.073-3.111c.852-1.432 3.609-5.472 8.315-6.866.984 2.509 1.674 5.436 1.742 8.755-3.566 1.199-7.327.392-10.057-1.889zm11.532 1.263c-.131-3.189-.782-6.017-1.71-8.467 2.082-.325 4.492-.108 7.225.987-.581 3.261-2.666 6.002-5.515 7.48zm5.672-9.031c-3.01-1.131-5.663-1.272-7.959-.834-.355-.8-.728-1.569-1.123-2.277 3.523-1.407 5.605-3.122 6.537-4.03 1.645 1.904 2.622 4.369 2.545 7.141zm-3.61-8.209c-.848.807-2.845 2.437-6.26 3.77-1.674-2.648-3.464-4.516-4.598-5.562 3.628-1.494 7.812-.856 10.858 1.792zm-12.292-1.059c.856.753 2.735 2.561 4.548 5.357-2.49.802-5.612 1.391-9.409 1.474.604-2.894 2.408-5.346 4.861-6.831zm-5.051 8.337c4.25-.069 7.69-.74 10.409-1.648.376.659.733 1.377 1.076 2.123-4.735 1.508-7.694 5.401-8.827 7.159-1.828-2.04-2.836-4.702-2.658-7.634z"/></svg>                                        </a>
                                            </li>
                                        @endif
                                    </ul>


                            </div>
                        @endif


                    </div>

                    <div class="arist-header" style="display: none">
                        <div class="artist-social">
                            <ul class="list-bts">
                                @if(isset($artist->facebook))
                                <li>
                                    <a href="{{ $artist->facebook }}" target="_blank">
                                        <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"/></svg>
                                    </a>
                                </li>
                                @endif
                                @if(isset($artist->instagram))
                                    <li>
                                        <a href="{{ $artist->instagram }}" target="_blank" >
                                            <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m12.004 5.838c-3.403 0-6.158 2.758-6.158 6.158 0 3.403 2.758 6.158 6.158 6.158 3.403 0 6.158-2.758 6.158-6.158 0-3.403-2.758-6.158-6.158-6.158zm0 10.155c-2.209 0-3.997-1.789-3.997-3.997s1.789-3.997 3.997-3.997 3.997 1.789 3.997 3.997c.001 2.208-1.788 3.997-3.997 3.997z"/><path d="m16.948.076c-2.208-.103-7.677-.098-9.887 0-1.942.091-3.655.56-5.036 1.941-2.308 2.308-2.013 5.418-2.013 9.979 0 4.668-.26 7.706 2.013 9.979 2.317 2.316 5.472 2.013 9.979 2.013 4.624 0 6.22.003 7.855-.63 2.223-.863 3.901-2.85 4.065-6.419.104-2.209.098-7.677 0-9.887-.198-4.213-2.459-6.768-6.976-6.976zm3.495 20.372c-1.513 1.513-3.612 1.378-8.468 1.378-5 0-7.005.074-8.468-1.393-1.685-1.677-1.38-4.37-1.38-8.453 0-5.525-.567-9.504 4.978-9.788 1.274-.045 1.649-.06 4.856-.06l.045.03c5.329 0 9.51-.558 9.761 4.986.057 1.265.07 1.645.07 4.847-.001 4.942.093 6.959-1.394 8.453z"/><circle cx="18.406" cy="5.595" r="1.439"/></svg>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($artist->behance))
                                    <li>
                                        <a href="{{ $artist->behance }}" target="_blank" >
                                              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 511.958 511.958" style="enable-background:new 0 0 511.958 511.958;" xml:space="preserve"><g><g><g><path d="M210.624,240.619c10.624-5.344,18.656-11.296,24.16-17.728c9.792-11.584,14.624-26.944,14.624-45.984 c0-18.528-4.832-34.368-14.496-47.648c-16.128-21.632-43.424-32.704-82.016-33.28H0v312.096h142.56 c16.064,0,30.944-1.376,44.704-4.192c13.76-2.848,25.664-8.064,35.744-15.68c8.96-6.624,16.448-14.848,22.4-24.544 c9.408-14.656,14.112-31.264,14.112-49.76c0-17.92-4.128-33.184-12.32-45.728C238.912,255.627,226.752,246.443,210.624,240.619z  M63.072,150.187h68.864c15.136,0,27.616,1.632,37.408,4.864c11.328,4.704,16.992,14.272,16.992,28.864 c0,13.088-4.32,22.24-12.864,27.392c-8.608,5.152-19.776,7.744-33.472,7.744H63.072V150.187z M171.968,348.427 c-7.616,3.68-18.336,5.504-32.064,5.504H63.072v-83.232h77.888c13.568,0.096,24.128,1.888,31.68,5.248 c13.44,6.08,20.128,17.216,20.128,33.504C192.768,328.651,185.856,341.579,171.968,348.427z"/><rect x="327.168" y="110.539" width="135.584" height="38.848"/><path d="M509.856,263.851c-2.816-18.08-9.024-33.984-18.688-47.712c-10.592-15.552-24.032-26.944-40.384-34.144 c-16.288-7.232-34.624-10.848-55.04-10.816c-34.272,0-62.112,10.72-83.648,32c-21.472,21.344-32.224,52.032-32.224,92.032 c0,42.656,11.872,73.472,35.744,92.384c23.776,18.944,51.232,28.384,82.4,28.384c37.728,0,67.072-11.232,88.032-33.632 	c13.408-14.144,20.992-28.064,22.656-41.728H446.24c-3.616,6.752-7.808,12.032-12.608,15.872 c-8.704,7.04-20.032,10.56-33.92,10.56c-13.216,0-24.416-2.912-33.76-8.704c-15.424-9.28-23.488-25.536-24.512-48.672h170.464 C512.16,289.739,511.52,274.411,509.856,263.851z M342.976,269.835c2.24-15.008,7.68-26.912,16.32-35.712 c8.64-8.768,20.864-13.184,36.512-13.216c14.432,0,26.496,4.128,36.32,12.416c9.696,8.352,15.168,20.48,16.288,36.512H342.976z" /></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($artist->dribbble))
                                    <li>
                                        <a href="{{ $artist->dribbble }}" target="_blank" >
                                            <svg id="regular" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m16.354 23.17c.02-.006.039-.014.059-.021 12.215-4.853 8.836-23.149-4.413-23.149-6.649 0-12 5.42-12 12 0 8.327 8.434 14.269 16.354 11.17zm-11.073-3.111c.852-1.432 3.609-5.472 8.315-6.866.984 2.509 1.674 5.436 1.742 8.755-3.566 1.199-7.327.392-10.057-1.889zm11.532 1.263c-.131-3.189-.782-6.017-1.71-8.467 2.082-.325 4.492-.108 7.225.987-.581 3.261-2.666 6.002-5.515 7.48zm5.672-9.031c-3.01-1.131-5.663-1.272-7.959-.834-.355-.8-.728-1.569-1.123-2.277 3.523-1.407 5.605-3.122 6.537-4.03 1.645 1.904 2.622 4.369 2.545 7.141zm-3.61-8.209c-.848.807-2.845 2.437-6.26 3.77-1.674-2.648-3.464-4.516-4.598-5.562 3.628-1.494 7.812-.856 10.858 1.792zm-12.292-1.059c.856.753 2.735 2.561 4.548 5.357-2.49.802-5.612 1.391-9.409 1.474.604-2.894 2.408-5.346 4.861-6.831zm-5.051 8.337c4.25-.069 7.69-.74 10.409-1.648.376.659.733 1.377 1.076 2.123-4.735 1.508-7.694 5.401-8.827 7.159-1.828-2.04-2.836-4.702-2.658-7.634z"/></svg>                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="#follow" class="borderclass" data-username="viensla" data-following="" data-text-start="Follow" data-text-end="Following">
                                        <span class="js-bt-content">@lang('site.Follow')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="artist-center">
                            @if(isset($artist->images[0]->small))
                                <div class="artist-avatar">
                                        <img src="{{ asset($artist->images[0]->small) }}"  alt="">
                                </div>
                            @endif

                            <div class="artist-name">
                                {{ $artist->firstname }} {{ $artist->lastname }}
                            </div>

                                @if(isset($artist->city) || isset($artist->city))
                                    <div class="artist-location">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-4808 -20688 14.286 20" class="Profile-locationIcon-2q2"><g><path d="M-4800.857-20688a7.143 7.143 0 0 0-7.143 7.143c0 5.714 7.143 12.857 7.143 12.857s7.143-7.143 7.143-12.857a7.142 7.142 0 0 0-7.143-7.143zm0 10a2.857 2.857 0 1 1 2.857-2.859 2.858 2.858 0 0 1-2.857 2.859z"></path></g></svg>
                                        @if(isset($artist->country))
                                            {{ $artist->country->name_en }}
                                        @endif
                                        -
                                        @if(isset($artist->city))
                                            {{ $artist->city->name_en }}
                                        @endif
                                    </div>
                                @endif


                                @if(isset($artist->about))

                                    <div class="artist-about">
                                       {{ $artist->about }}
                                    </div>

                                @endif

                        </div>
                        <div class="artist-contact">
                            <ul class="list-bts">
                                @if(isset($artist->website))
                                    <li>
                                        <a href="{{ $artist->website }}" target="_blank" class="borderclass" >
                                            <span>@lang('site.Visit Site')</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="store-page">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <ol class="artup-list mt-5" >
                        <li class="">
                            <a href="#work" class="home-title new"> @lang('site.Works') </a>
                        </li>
                    </ol>

                    <ol class="artup-list" id="grid">

                        @foreach($projects as $key => $each)
                            <li>
                                <div class="artup-project">
                                    <a href="{{ asset('project/'.$each->id ) }}" class="artup-project-img">
                                        @if(isset($each->images[0]->medium))
                                            <img src="{{ asset($each->images[0]->medium) }}"  alt="">
                                        @endif
                                    </a>
                                    <a href="{{ asset('project/'.$each->id ) }}" class="artup-project-box">
                                        <div class="artup-project-title">
                                            <h1>
                                                @if(App::isLocale('ka'))
                                                    {!! $each->name !!}
                                                @endif
                                                @if(App::isLocale('en'))
                                                    {!! $each->name_en !!}
                                                @endif
                                            </h1>
                                        </div>
                                    </a>
                                    <div class="artup-project-detail">
                                        @if(isset($each->artist))
                                            <span class="artup-project-owner">
                                            @if(isset($each->artist->images[0]->small))
                                                    <a href="{{ asset('artist/'. $each->artist->id ) }}" class="artup-project-owner-avatar"><img src="{{ asset($each->artist->images[0]->small) }}"  alt=""></a>
                                                @endif
                                            <a href="{{ asset('artist/'. $each->artist->id ) }}" class="artup-project-owner-name">
                                                 @if(App::isLocale('ka'))
                                                    @if(isset($each->artist->username))
                                                        {{ $each->artist->username }}
                                                    @else
                                                        {{ $each->artist->firstname }} {{ $each->artist->lastname }}
                                                    @endif
                                                @endif

                                                @if(App::isLocale('en'))
                                                    @if(isset($each->artist->username_en))
                                                        {{ $each->artist->username_en }}
                                                    @else
                                                        {{ $each->artist->firstname_en }} {{ $each->artist->lastname_en }}
                                                    @endif
                                                @endif
                                            </a>
                                        </span>
                                        @endif

                                        <div class="artup-project-stats">
                                            @if(isset($each->location))
                                                <a href="{{ asset('project/'.$each->id ) }}">
                                                    @if(App::isLocale('ka'))
                                                        {{ $each->location->name }}
                                                    @endif
                                                    @if(App::isLocale('en'))
                                                        {{ $each->location->name_en }}
                                                    @endif
                                                </a>
                                                <a href="{{ asset('project/'.$each->id ) }}">
                                                    <svg class="mx-auto" id="Layer_1" enable-background="new 0 0 512 512" height="64" viewBox="0 0 512 512" width="64" xmlns="http://www.w3.org/2000/svg"> <g> <path d="m407.579 87.677c-31.073-53.624-86.265-86.385-147.64-87.637-2.62-.054-5.257-.054-7.878 0-61.374 1.252-116.566 34.013-147.64 87.637-31.762 54.812-32.631 120.652-2.325 176.123l126.963 232.387c.057.103.114.206.173.308 5.586 9.709 15.593 15.505 26.77 15.505 11.176 0 21.183-5.797 26.768-15.505.059-.102.116-.205.173-.308l126.963-232.387c30.304-55.471 29.435-121.311-2.327-176.123zm-151.579 144.323c-39.701 0-72-32.299-72-72s32.299-72 72-72 72 32.299 72 72-32.298 72-72 72z"></path> </g> </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach


                    </ol>
                </div>
                <div class="col-12">
                    {{ $projects->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('bodystart')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0" nonce="grH6Aqme"></script>
@endsection

@section('bodyend')
    <script type="text/javascript">

        function share() {
            var width = 626;
            var height = 436;
            var PageToShare = location.href;
            var sharerUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(PageToShare);
            var l = window.screenX + (window.outerWidth - width) / 2;
            var t = window.screenY + (window.outerHeight - height) / 2;
            var winProps = ['width='+width,'height='+height,'left='+l,'top='+t,'status=no','resizable=yes','toolbar=no','menubar=no','scrollbars=yes'].join(',');
            var win = window.open(sharerUrl, 'fbShareWin', winProps);
        }

    </script>

@endsection
