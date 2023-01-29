@extends('layouts.app')

@section('title', 'Add Location')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBoyZK-h4o2iLmcK9vjZS5Z_JIM8uP3sR4&callback=initMap"></script>
    <script  type="text/javascript">

        var country = function() {

            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                $('.select2').select2({
                    // minimumResultsForSearch: Infinity
                });
 
            };

            var _componentStates = function() {

                $('#country_id').on('change', function() {

                    $('#state_id').empty().append('<option value="" >---</option>');
                    $('#state_id option:first-child').attr("selected", true);
                    
                    var country_id = this.value;

                    $.getJSON('{{ asset('api/states/') }}/' + country_id, function(data) {
                        $.each(data, function(i, field) {
                            $('#state_id').append($('<option>', {
                                value: field.id,
                                @if(App::isLocale('en'))
                                    text: field.name_en
                                @endif
                                @if(App::isLocale('ka'))
                                    text: field.name
                                @endif
                            }));
                        });
                    });

                });

            };
            var _componentCities = function() {

                $('#state_id').on('change', function() {

                    $('#city_id').empty().append('<option value="" >---</option>');
                    $('#city_id option:first-child').attr("selected", true);

                    var state_id = this.value;

                    $.getJSON('{{ asset('api/cities/') }}/' + state_id, function(data) {
                        $.each(data, function(i, field) {
                            $('#city_id').append($('<option>', {
                                value: field.id,
                                @if(App::isLocale('en'))
                                    text: field.name_en
                                @endif
                                @if(App::isLocale('ka'))
                                    text: field.name
                                @endif
                            }));
                        });
                    });

                });

            };
            var _componentMap = function() {

                // for ie9 doesn't support debug console >>>
                if (!window.console) window.console = {};
                if (!window.console.log) window.console.log = function () { };
// ^^^

                $.fn.gMapsLatLonPicker = (function() {

                    var _self = this;

                    ///////////////////////////////////////////////////////////////////////////////////////////////
                    // PARAMETERS (MODIFY THIS PART) //////////////////////////////////////////////////////////////
                    _self.params = {
                        defLat : 0,
                        defLng : 0,
                        defZoom : 1,
                        queryLocationNameWhenLatLngChanges: true,
                        queryElevationWhenLatLngChanges: true,
                        mapOptions : {
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            mapTypeControl: false,
                            disableDoubleClickZoom: true,
                            zoomControlOptions: true,
                            streetViewControl: false
                        },
                        strings : {
                            markerText : "Drag this Marker",
                            error_empty_field : "Couldn't find coordinates for this place",
                            error_no_results : "Couldn't find coordinates for this place"
                        },
                        displayError : function(message) {
                            alert(message);
                        }
                    };


                    ///////////////////////////////////////////////////////////////////////////////////////////////
                    // VARIABLES USED BY THE FUNCTION (DON'T MODIFY THIS PART) ////////////////////////////////////
                    _self.vars = {
                        ID : null,
                        LATLNG : null,
                        map : null,
                        marker : null,
                        geocoder : null
                    };

                    ///////////////////////////////////////////////////////////////////////////////////////////////
                    // PRIVATE FUNCTIONS FOR MANIPULATING DATA ////////////////////////////////////////////////////
                    var setPosition = function(position) {
                        _self.vars.marker.setPosition(position);
                        _self.vars.map.panTo(position);

                        $(_self.vars.cssID + ".gllpZoom").val( _self.vars.map.getZoom() );
                        $(_self.vars.cssID + ".gllpLongitude").val( position.lng() );
                        $(_self.vars.cssID + ".gllpLatitude").val( position.lat() );

                        $(_self.vars.cssID).trigger("location_changed", $(_self.vars.cssID));

                        if (_self.params.queryLocationNameWhenLatLngChanges) {
                            getLocationName(position);
                        }
                        if (_self.params.queryElevationWhenLatLngChanges) {
                            getElevation(position);
                        }
                    };

                    // for reverse geocoding
                    var getLocationName = function(position) {
                        var latlng = new google.maps.LatLng(position.lat(), position.lng());
                        _self.vars.geocoder.geocode({'latLng': latlng}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK && results[1]) {
                                $(_self.vars.cssID + ".gllpLocationName").val(results[1].formatted_address);
                            } else {
                                $(_self.vars.cssID + ".gllpLocationName").val("");
                            }
                            $(_self.vars.cssID).trigger("location_name_changed", $(_self.vars.cssID));
                        });
                    };

                    // for getting the elevation value for a position
                    var getElevation = function(position) {
                        var latlng = new google.maps.LatLng(position.lat(), position.lng());

                        var locations = [latlng];

                        var positionalRequest = { 'locations': locations };

                        _self.vars.elevator.getElevationForLocations(positionalRequest, function(results, status) {
                            if (status == google.maps.ElevationStatus.OK) {
                                if (results[0]) {
                                    $(_self.vars.cssID + ".gllpElevation").val( results[0].elevation.toFixed(3));
                                } else {
                                    $(_self.vars.cssID + ".gllpElevation").val("");
                                }
                            } else {
                                $(_self.vars.cssID + ".gllpElevation").val("");
                            }
                            $(_self.vars.cssID).trigger("elevation_changed", $(_self.vars.cssID));
                        });
                    };

                    // search function
                    var performSearch = function(string, silent) {
                        if (string == "") {
                            if (!silent) {
                                _self.params.displayError( _self.params.strings.error_empty_field );
                            }
                            return;
                        }
                        _self.vars.geocoder.geocode(
                            {"address": string},
                            function(results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    $(_self.vars.cssID + ".gllpZoom").val(11);
                                    _self.vars.map.setZoom( parseInt($(_self.vars.cssID + ".gllpZoom").val()) );
                                    setPosition( results[0].geometry.location );
                                } else {
                                    if (!silent) {
                                        _self.params.displayError( _self.params.strings.error_no_results );
                                    }
                                }
                            }
                        );
                    };

                    ///////////////////////////////////////////////////////////////////////////////////////////////
                    // PUBLIC FUNCTIONS  //////////////////////////////////////////////////////////////////////////
                    var publicfunc = {

                        // INITIALIZE MAP ON DIV //////////////////////////////////////////////////////////////////
                        init : function(object) {

                            if ( !$(object).attr("id") ) {
                                if ( $(object).attr("name") ) {
                                    $(object).attr("id", $(object).attr("name") );
                                } else {
                                    $(object).attr("id", "_MAP_" + Math.ceil(Math.random() * 10000) );
                                }
                            }

                            _self.vars.ID = $(object).attr("id");
                            _self.vars.cssID = "#" + _self.vars.ID + " ";

                            _self.params.defLat  = $(_self.vars.cssID + ".gllpLatitude").val()  ? $(_self.vars.cssID + ".gllpLatitude").val()		: _self.params.defLat;
                            _self.params.defLng  = $(_self.vars.cssID + ".gllpLongitude").val() ? $(_self.vars.cssID + ".gllpLongitude").val()	    : _self.params.defLng;
                            _self.params.defZoom = $(_self.vars.cssID + ".gllpZoom").val()      ? parseInt($(_self.vars.cssID + ".gllpZoom").val()) : _self.params.defZoom;

                            _self.vars.LATLNG = new google.maps.LatLng(_self.params.defLat, _self.params.defLng);

                            _self.vars.MAPOPTIONS		 = _self.params.mapOptions;
                            _self.vars.MAPOPTIONS.zoom   = _self.params.defZoom;
                            _self.vars.MAPOPTIONS.center = _self.vars.LATLNG;

                            _self.vars.map = new google.maps.Map($(_self.vars.cssID + ".gllpMap").get(0), _self.vars.MAPOPTIONS);
                            _self.vars.geocoder = new google.maps.Geocoder();
                            _self.vars.elevator = new google.maps.ElevationService();

                            _self.vars.marker = new google.maps.Marker({
                                position: _self.vars.LATLNG,
                                map: _self.vars.map,
                                title: _self.params.strings.markerText,
                                draggable: true
                            });

                            // Set position on doubleclick
                            google.maps.event.addListener(_self.vars.map, 'dblclick', function(event) {
                                setPosition(event.latLng);
                            });

                            // Set position on marker move
                            google.maps.event.addListener(_self.vars.marker, 'dragend', function(event) {
                                setPosition(_self.vars.marker.position);
                            });

                            // Set zoom feld's value when user changes zoom on the map
                            google.maps.event.addListener(_self.vars.map, 'zoom_changed', function(event) {
                                $(_self.vars.cssID + ".gllpZoom").val( _self.vars.map.getZoom() );
                                $(_self.vars.cssID).trigger("location_changed", $(_self.vars.cssID));
                            });

                            // Update location and zoom values based on input field's value
                            $(_self.vars.cssID + ".gllpUpdateButton").bind("click", function() {
                                var lat = $(_self.vars.cssID + ".gllpLatitude").val();
                                var lng = $(_self.vars.cssID + ".gllpLongitude").val();
                                var latlng = new google.maps.LatLng(lat, lng);
                                _self.vars.map.setZoom( parseInt( $(_self.vars.cssID + ".gllpZoom").val() ) );
                                setPosition(latlng);
                            });

                            // Search function by search button
                            $(_self.vars.cssID + ".gllpSearchButton").bind("click", function() {
                                performSearch( $(_self.vars.cssID + ".gllpSearchField").val(), false );
                            });

                            // Search function by gllp_perform_search listener
                            $(document).bind("gllp_perform_search", function(event, object) {
                                performSearch( $(object).attr('string'), true );
                            });

                            // Zoom function triggered by gllp_perform_zoom listener
                            $(document).bind("gllp_update_fields", function(event) {
                                var lat = $(_self.vars.cssID + ".gllpLatitude").val();
                                var lng = $(_self.vars.cssID + ".gllpLongitude").val();
                                var latlng = new google.maps.LatLng(lat, lng);
                                _self.vars.map.setZoom( parseInt( $(_self.vars.cssID + ".gllpZoom").val() ) );
                                setPosition(latlng);
                            });
                        },

                        // EXPORT PARAMS TO EASILY MODIFY THEM ////////////////////////////////////////////////////
                        params : _self.params

                    };

                    return publicfunc;
                });

                $(document).ready( function() {
                    if (!$.gMapsLatLonPickerNoAutoInit) {
                        $(".gllpLatlonPicker").each(function () {
                            $obj = $(document).gMapsLatLonPicker();
                            $obj.init( $(this) );
                        });
                    }
                });

                $(document).bind("location_changed", function(event, object) {
                    console.log("changed: " + $(object).attr('id') );
                });


            };

            return {
                init: function() {
                    _componentSelect2();
                    _componentStates();
                    _componentCities();
                    _componentMap();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            country.init();
        });
    </script>

    <style>
        .gllpMap{
            width:100%;
            height:540px;
        }
    </style>
@endsection


@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Add_Location') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">
        <form method="post" id="itemForm" action="{{ asset('admin/locations/add') }}" autocomplete="off">
            @csrf

            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body">

                                <div class="form-group">
                                    <label>@lang('app.Country') <span class="text-danger">*</span></label>
                                    <select name="country_id" id="country_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                        <option value=""></option>
                                        @foreach($countries as $each)
                                            @if(App::isLocale('ka'))
                                                <option @if( old('country_id') == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                            @endif
                                            @if(App::isLocale('en'))
                                                <option @if( old('country_id') == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country_id'))
                                        <span class="form-text text-danger">{{ $errors->first('country_id') }}</span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label>@lang('app.State') <span class="text-danger">*</span></label>
                                    <select name="state_id" id="state_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                        <option value=""></option>
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="form-text text-danger">{{ $errors->first('state_id') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>@lang('app.City') <span class="text-danger">*</span></label>
                                    <select name="city_id" id="city_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                        <option value=""></option>
                                    </select>
                                    @if ($errors->has('city_id'))
                                        <span class="form-text text-danger">{{ $errors->first('city_id') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>@lang('app.Name') <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @if ($errors->has('name')) border-danger @endif" value="{{ old('name') }}" name="name">
                                    @if ($errors->has('name'))
                                        <span class="form-text text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>@lang('app.Name') <b>@lang('app.Eng')</b>  <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @if ($errors->has('name_en')) border-danger @endif" value="{{ old('name_en') }}" name="name_en">
                                    @if ($errors->has('name_en'))
                                        <span class="form-text text-danger">{{ $errors->first('name_en') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>@lang('app.Sort')</label>
                                    <input type="number" class="form-control @if ($errors->has('sort')) border-danger @endif" value="{{ old('sort') }}" name="sort">
                                    @if ($errors->has('sort'))
                                        <span class="form-text text-danger">{{ $errors->first('sort') }}</span>
                                    @endif
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">@lang('app.Submit') <i class="icon-paperplane ml-2"></i></button>
                                </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body">

                            <fieldset class="gllpLatlonPicker">
                                <div  class="gllpMap">Google Maps</div>
                                <input type="hidden" class="gllpLatitude" name="latitude"   value="41.720000"/>
                                <input type="hidden" class="gllpLongitude" name="longitude" value="44.780000"/>
                                <input type="hidden" class="gllpZoom" name="zoom" value="13"/>
                            </fieldset>

                        </div>
                    </div>

                </div>
            </div>

        </form>

         
    </div>

@endsection


@section('bodyend')

@endsection
