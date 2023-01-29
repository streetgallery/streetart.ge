@extends('layouts.site')


@section('head')

    <meta property="og:url" content="{{ asset('project') }}/{{ $item->id }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="artup" />
    <meta property="article:publisher" content="artup" />

    @if(App::isLocale('ka'))

        @if(isset($item->description))
            <meta name="description" content="{{ $item->description }}">
        @endif

        @if(isset($item->keywords))
            <meta name="keywords" content="{{ $item->keywords }}">
        @endif

        @if(isset($item->name_en))
            <meta property="og:title" content="{{ $item->name }}" />
        @endif

        @if(isset($item->description))
            <meta property="og:description" content="{{ $item->description }}" />
        @endif

    @endif
    @if(App::isLocale('en'))

        @if(isset($item->description_en))
            <meta name="description" content="{{ $item->description_en }}">
        @endif

        @if(isset($item->keywords_en))
            <meta name="keywords" content="{{ $item->keywords_en }}">
        @endif

        @if(isset($item->name_en))
            <meta property="og:title" content="{{ $item->name_en }}" />
        @endif
        @if(isset($item->description_en))
            <meta property="og:description" content="{{ $item->description_en }}" />
        @endif
    @endif

    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="620" />
    <meta property="og:image:height" content="541" />

    @if(isset($item->images[0]->medium))
        <meta property="og:image" content="{{ asset($item->images[0]->medium) }}" />
    @endif

    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}/">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}/">

@endsection

@section('content')
    <section class="project-section">

        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="inner-project">
                        

                        <div class="owl-carousel owl-project">
                            @foreach($item->images as $each)

                                @if(isset($each->medium))
                                    <div class="item">

                                        <div class="item-image">
                                            <img class="owl-lazy" data-src="{{ asset($each->medium) }}" />
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="project-detail">

                            @if(App::isLocale('ka'))
                                <h1>{{ $item->name }}</h1>
                                <div class="content-project">{!! $item->content !!}</div>
                            @endif

                            @if(App::isLocale('en'))
                                <h1>{{ $item->name_en }}</h1>
                                <div>{!! $item->content_en !!}</div>
                            @endif

                            @if(isset($item->location))
                                <a href="{{ asset('location/'. $item->location->id) }}" class="location-pinblue">
                                    <span class="pinloc">
                                        <svg class="mx-auto" id="Layer_1" enable-background="new 0 0 512 512" height="64" viewBox="0 0 512 512" width="64" xmlns="http://www.w3.org/2000/svg"> <g> <path d="m407.579 87.677c-31.073-53.624-86.265-86.385-147.64-87.637-2.62-.054-5.257-.054-7.878 0-61.374 1.252-116.566 34.013-147.64 87.637-31.762 54.812-32.631 120.652-2.325 176.123l126.963 232.387c.057.103.114.206.173.308 5.586 9.709 15.593 15.505 26.77 15.505 11.176 0 21.183-5.797 26.768-15.505.059-.102.116-.205.173-.308l126.963-232.387c30.304-55.471 29.435-121.311-2.327-176.123zm-151.579 144.323c-39.701 0-72-32.299-72-72s32.299-72 72-72 72 32.299 72 72-32.298 72-72 72z"></path> </g> </svg>
                                    </span>
                                    @if(App::isLocale('ka'))
                                        <span>{{ $item->location->name }}</span>
                                    @endif
                                    @if(App::isLocale('en'))
                                        <span>{{ $item->location->name_en }}</span>
                                    @endif
                                </a>
                            @endif


                                <div  class="artist-project mt-5">

                                    @if($item->artist)
                                        <div  class="artist-detail">
                                        @if($item->artist->images[0])
                                            <a class="user-avatar" href="{{ asset('artist/'. $item->artist->id ) }}" >
                                                <img src="{{ $item->artist->images[0]->small }}"  >
                                            </a>
                                        @endif
                                        <a class="artist-name" href="{{ asset('artist/'. $item->artist->id ) }}">

                                            @if(App::isLocale('ka'))
                                                @if(isset($item->artist->username))
                                                    {{ $item->artist->username }}
                                                @else
                                                    <h1>{{ $item->artist->firstname }} {{ $item->artist->lastname }}
                                                @endif
                                            @endif

                                            @if(App::isLocale('en'))
                                                @if(isset($item->artist->username_en))
                                                    {{ $item->artist->username_en }}
                                                @else
                                                    {{ $item->artist->firstname_en }} {{ $item->artist->lastname_en }}
                                                @endif
                                            @endif
                                        </a>
                                    </div>
                                    @endif
                                    <div class="share-art">
                                        <span>@lang('site.Share'):</span>
                                        <ul>
                                            <li>
                                                <a class="facebook" target="_blank" href="{{ asset('project/'. $item->id ) }}" onclick="share();">
                                                    <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"></path></svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                            @if(App::isLocale('ka'))
                                @if (!is_null($item->keywords))
                                    <ul class="keyword-project mt-3 d-none">
                                        @foreach(explode(', ', $item->keywords) as $keyword)
                                            <li><a href="{{ asset('projects?keyword='. $keyword) }}" >  {{ $keyword }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endif

                            @if(App::isLocale('en'))
                                @if (!is_null($item->keywords_en))
                                    <ul class="keyword-project mt-3 d-none">
                                        @foreach(explode(', ', $item->keywords_en) as $keyword)
                                            <li><a href="{{ asset('projects?keyword='. $keyword) }}" >  {{ $keyword }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endif

                        </div>

                    </div>
                </div>
                <div class="col-md-5">
                    <div id="inner-project-map"></div>
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

        function initMap() {

            var map = new google.maps.Map(document.getElementById('inner-project-map'), {
                zoom: 17,
                @if($item->if_not_location == 1)
                    center: {lat: {{ $item->latitude }}, lng: {{ $item->longitude }}},
                @else
                    @if(isset($item->location))
                        center: {lat: {{ $item->location->latitude }}, lng: {{ $item->location->longitude }}},
                    @endif
                @endif
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                mapTypeControl: false,
                scaleControl: true,
                panControl: true,
                navigationControl: false,
                streetViewControl: false,
                fullscreenControl: false,
                scrollwheel: false,
                draggable: true,
                styles: [{
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#444444"}]
                }, {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{"color": "#f4f7f6"}]
                }, {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{"visibility": "off"}]
                }, {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{"saturation": -100}, {"lightness": 45}]
                }, {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [{"visibility": "simplified"}]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels.icon",
                    "stylers": [{"visibility": "simplified"}]
                }, {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [{"visibility": "on"}]
                }, {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{"color": "#46bcec"}, {"visibility": "on"}]
                }]
            });

            var image = '{{ asset('img/pin.svg') }}';

            var bounds = new google.maps.LatLngBounds();

            var infoWin = new google.maps.InfoWindow();

            var markers = locations.map(function(location, i) {
                bounds.extend(location);
               // map.fitBounds(bounds);
                var marker = new google.maps.Marker({
                    icon: image,
                    scaledSize: new google.maps.Size(30, 5), // size
                    position: location
                });
                google.maps.event.addListener(marker, 'click', function(evt) {
                    infoWin.setContent(location.info);
                    infoWin.open(map, marker);
                });
                return marker;
            });

            var markerCluster = new MarkerClusterer(map, markers, {
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
            });

        }
        var locations = [
             {
                 @if($item->if_not_location == 1)
                     lat: {{ $item->latitude }},
                     lng: {{ $item->longitude }},
                 @else
                    @if(isset($item->location))
                        lat: {{ $item->location->latitude }},
                        lng: {{ $item->location->longitude }},
                    @endif
                 @endif
                info: '<div class="event_box event_map" > '+
                        @if(isset($item->images[0]->medium))
                            '<div class="event_cover " style="background-image: url(\'{{ asset($item->images[0]->medium) }}\');"></div>'+
                        @endif
                    '</div>'
            }
        ];

        google.maps.event.addDomListener(window, "load", initMap);

        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        directionsDisplay.setMap(map);


    </script>
    <script src="//developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoyZK-h4o2iLmcK9vjZS5Z_JIM8uP3sR4&callback=initMap"></script>


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

    <script type="text/javascript">

        if (document.referrer == "") {
            $( ".backdiv" ).hide();
        }
        function goBack() {
            window.history.back();
        }
    </script>

    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>

    <script>
        $('.owl-project').owlCarousel({
            loop:false,
            items:1,
            margin:0,
            nav:true,
            dots:false,
            autoplay:true,
            autoHeight:false,
            autoplayTimeout:9000,
            autoplayHoverPause:false,
            lazyLoad: true,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            mouseDrag: false,
            navText:[
                        '<svg style="fill: rgb(0, 0, 0)" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve"><g><g><path d="M492,236H68.442l70.164-69.824c7.829-7.792,7.859-20.455,0.067-28.284c-7.792-7.83-20.456-7.859-28.285-0.068 l-104.504,104c-0.007,0.006-0.012,0.013-0.018,0.019c-7.809,7.792-7.834,20.496-0.002,28.314c0.007,0.006,0.012,0.013,0.018,0.019 l104.504,104c7.828,7.79,20.492,7.763,28.285-0.068c7.792-7.829,7.762-20.492-0.067-28.284L68.442,276H492 c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>',
                        '<svg style="fill: rgb(0, 0, 0)" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve"><g><g><path d="M492,236H68.442l70.164-69.824c7.829-7.792,7.859-20.455,0.067-28.284c-7.792-7.83-20.456-7.859-28.285-0.068 l-104.504,104c-0.007,0.006-0.012,0.013-0.018,0.019c-7.809,7.792-7.834,20.496-0.002,28.314c0.007,0.006,0.012,0.013,0.018,0.019 l104.504,104c7.828,7.79,20.492,7.763,28.285-0.068c7.792-7.829,7.762-20.492-0.067-28.284L68.442,276H492 c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>'
                    ],

        });

    </script>


@endsection
