@section('head')

@endsection

@section('title', '- მთავარი')
@section('title_en', '- Home')
@section('body_class', 'head-no-border')

@extends('layouts.site')

@section('content')
    <div id="map2"></div>

    <section class="store-page">
        <div class="container">
            <div class="row">
                <div class="col-12">


                    @if ($banners->isNotEmpty())

                        <ol class="artup-list artup-banners mt-2" >
                            @foreach($banners as $item)
                                <li class="ads">
                                    <a target="_blank" href="{{ $item->link }}" class="">
                                        @if(isset($item->images[0]->original))
                                            <img src="{{ asset($item->images[0]->original) }}"  alt="">
                                        @endif
                                     </a>
                                </li>
                            @endforeach

                        </ol>

                    @endif

                    <ol class="artup-list list-title-color" >
                        <li class="">
                            <a href="/projects" class="home-title new"> @lang('site.NEW') </a>
                        </li>
                        <li class="mb-0">
                            <a href="/projects" class="home-title archive"> @lang('site.ARCHIVE') </a>
                        </li>
                        <li class="mb-0">
                            <a href="/artists" class="home-title artists"> @lang('site.ARTISTS') </a>
                        </li>
                        <li class="mb-0">
                            <a href="/article/2" class="home-title events"> @lang('site.FESTIVALS') </a>
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
            </div>
        </div>
    </section>
 
@endsection

@section('bodyend')

    <script>

        function initMap() {

            var map = new google.maps.Map(document.getElementById('map2'), {
                zoom: 11,
                center: {lat: 41.7555086, lng: 44.8386696},
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_CENTER
                },
                mapTypeControl: false,
                scaleControl: true,
                panControl: true,
                navigationControl: false,
                streetViewControl: true,
                fullscreenControl: true,
                scrollwheel: false,
                draggable: true,
                // styles:[ { "featureType": "administrative", "elementType": "all", "stylers": [ { "saturation": "-100" } ] }, { "featureType": "administrative.province", "elementType": "all", "stylers": [ { "visibility": "off" } ] }, { "featureType": "landscape", "elementType": "all", "stylers": [ { "saturation": -100 }, { "lightness": 65 }, { "visibility": "on" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "saturation": -100 }, { "lightness": "50" }, { "visibility": "simplified" } ] }, { "featureType": "road", "elementType": "all", "stylers": [ { "saturation": "-100" } ] }, { "featureType": "road.highway", "elementType": "all", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.arterial", "elementType": "all", "stylers": [ { "lightness": "30" } ] }, { "featureType": "road.local", "elementType": "all", "stylers": [ { "lightness": "40" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "saturation": -100 }, { "visibility": "simplified" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ { "hue": "#ffff00" }, { "lightness": -25 }, { "saturation": -97 } ] }, { "featureType": "water", "elementType": "labels", "stylers": [ { "lightness": -25 }, { "saturation": -100 } ] } ]
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
                //styles:  [ { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#e9e9e9" }, { "lightness": 17 } ] }, { "featureType": "landscape", "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" }, { "lightness": 20 } ] }, { "featureType": "road.highway", "elementType": "geometry.fill", "stylers": [ { "color": "#ffffff" }, { "lightness": 17 } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "color": "#ffffff" }, { "lightness": 29 }, { "weight": 0.2 } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#ffffff" }, { "lightness": 18 } ] }, { "featureType": "road.local", "elementType": "geometry", "stylers": [ { "color": "#ffffff" }, { "lightness": 16 } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#f5f5f5" }, { "lightness": 21 } ] }, { "featureType": "poi.park", "elementType": "geometry", "stylers": [ { "color": "#dedede" }, { "lightness": 21 } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "visibility": "on" }, { "color": "#ffffff" }, { "lightness": 16 } ] }, { "elementType": "labels.text.fill", "stylers": [ { "saturation": 36 }, { "color": "#333333" }, { "lightness": 40 } ] }, { "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "featureType": "transit", "elementType": "geometry", "stylers": [ { "color": "#f2f2f2" }, { "lightness": 19 } ] }, { "featureType": "administrative", "elementType": "geometry.fill", "stylers": [ { "color": "#fefefe" }, { "lightness": 20 } ] }, { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [ { "color": "#fefefe" }, { "lightness": 17 }, { "weight": 1.2 } ] } ]
            });

            var image = '{{ asset('img/pin.svg') }}';

            var bounds = new google.maps.LatLngBounds();

            var infoWin = new google.maps.InfoWindow();

            var markers = locations.map(function(location, i) {
                bounds.extend(location);
                map.fitBounds(bounds);
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

                @foreach($projectsMap as $each)
                {
                    lat: {{ $each->latitude }},
                    lng: {{ $each->longitude }},
                    info: '<a href="/project/{{ $each->id }}" class="event_box event_map" > '+
                            @if(isset($each->images[0]->medium))
                                '<div class="event_cover " style="background-image: url(\'{{ asset($each->images[0]->medium) }}\');"></div>'+
                            @endif
                                '<div class="event_title">@if(App::isLocale('ka')) {{ $each->name }}  @endif @if(App::isLocale('en'))  {{$each->name_en}}  @endif </div> '+
                        '   <div class="events-list"> '+
                        '<table class="table table-event"> '+
                        '</table> '+
                        '   </div> '+
                        '</a>'
                },
            @endforeach

            @foreach($locations as $each)
                {
                    lat: {{ $each->latitude }},
                    lng: {{ $each->longitude }},
                    info: '<div class="event_box event_map" > '+
                            @if(isset($each->images[0]->medium))
                                '<a href="/location/{{ $each->id }}" class="event_cover " style="background-image: url(\'{{ asset($each->images[0]->medium) }}\');"></a>'+
                            @endif
                                '<a href="/location/{{ $each->id }}" class="event_title">@if(App::isLocale('ka')) {{ $each->name }}  @endif @if(App::isLocale('en'))  {{$each->name_en}}  @endif </a> '+
                        '   <div class="events-list"> '+
                        '<table class="table table-event"> '+
                        '</table> '+
                        '   </div> '+
                        '</div>'
                }
                @if($loop->last)
                @else  ,
                @endif
            @endforeach

        ];

        google.maps.event.addDomListener(window, "load", initMap);

        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        directionsDisplay.setMap(map);

    </script>

    <script src="//developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoyZK-h4o2iLmcK9vjZS5Z_JIM8uP3sR4&callback=initMap"></script>

@endsection