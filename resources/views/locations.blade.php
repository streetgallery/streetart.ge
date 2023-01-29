@extends('layouts.site')

@section('head')

<style>
    #map2 {
        position: relative;
        height: calc(100vh - 400px);
        position: relative;
        overflow: hidden;
        border: #e1e1e1 1px solid;
        border-radius: 5px;
        background-color: #666;
        margin-bottom: 30px;
    }
</style>

@endsection



@section('content')


    <section class="store-page"  >
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        <div id="map2" ></div>

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

                @foreach($projects as $each)
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
