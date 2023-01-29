@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dropzone.min.css') }}">
@endsection

@section('title', '- პროფიილი')
@section('title_en', '- Profile')

@extends('layouts.site')

@section('content')
    <section class="add-project-section">
        <div class="container">
            <div class="row">

                <div class="col-md-12">

                    <div   class="userformaction mt-4"  >
                    <form method="POST" id="addform" class="" action="{{ asset('add-project') }}" autocomplete="off">
                        @csrf

                        <ul class="nav nav-tabs nav-lang rounded">
                            <li class="nav-item">
                                <a href="#content-ka" class="nav-link active rounded-left" data-toggle="tab">
                                    @lang('site.Georgian')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#content-en" class="nav-link" data-toggle="tab">
                                    @lang('site.English')
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="content-ka">
                                <div class="form-group">
                                    <input type="text" placeholder="@lang('app.Name')"  onfocus="this.placeholder = ''" onblur="this.placeholder = '@lang('app.Name')'" class="form-control @if ($errors->has('name')) border-danger @endif" value="{{  old('name') }}" name="name"  autocomplete="off">
                                    @if ($errors->has('name'))
                                        <span class="form-text text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <textarea name="content" id="content" class="form-control ckeditor"  rows="4" cols="4">{{  old('content')  }}</textarea>
                            </div>

                            <div class="tab-pane fade" id="content-en">
                                <div class="form-group">
                                    <input type="text" placeholder="@lang('app.Name') @lang('app.Eng')" class="form-control @if ($errors->has('name_en')) border-danger @endif" value="{{  old('content_en') }}" name="name_en">
                                    @if ($errors->has('name_en'))
                                        <span class="form-text text-danger">{{ $errors->first('name_en') }}</span>
                                    @endif
                                </div>
                                <textarea name="content_en" class="form-control ckeditor" id="content_en" rows="4" cols="4">{{ old('content_en')   }}</textarea>
                            </div>

                        </div>
                        
                        <div class="form-group mt-4">
                            <label>@lang('app.Category')</label>
                            <select name="category_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                <option value=""></option>
                                @foreach($categories as $each)
                                    @if(App::isLocale('ka'))
                                        <option @if( old('category_id') == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                    @endif
                                    @if(App::isLocale('en'))
                                        <option @if(old('category_id') == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <span class="form-text text-danger">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>

                        <div class="form-group ">
                            <label>@lang('app.Artist')</label>
                            <select name="artist_id" id="artist_id" class="form-control select2" data-fouc>
                                <option value="">---</option>


                                @if(App::isLocale('ka'))
                                    <option selected value="{{ Auth::user()->id }}">
                                        @if(isset(Auth::user()->username))
                                            {{ Auth::user()->username }}
                                        @else
                                            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                        @endif
                                    </option>
                                @endif
                                @if(App::isLocale('en'))
                                    <option selected value="{{ Auth::user()->id }}">
                                        @if(isset(Auth::user()->username_en))
                                            {{ Auth::user()->username_en }}
                                        @else
                                            {{ Auth::user()->firstname_en }} {{ Auth::user()->lastname_en }}
                                        @endif
                                    </option>
                                @endif



                                @foreach($artists as $each)
                                    @if(App::isLocale('ka'))
                                        <option @if(old('artist_id') == $each->id) selected @endif value="{{ $each->id }}">
                                            @if(isset($each->username))
                                                {{ $each->username }}
                                            @else
                                                {{ $each->firstname }} {{ $each->lastname }}
                                            @endif
                                        </option>
                                    @endif
                                    @if(App::isLocale('en'))
                                        <option @if(old('artist_id') == $each->id) selected @endif value="{{ $each->id }}">
                                            @if(isset($each->username_en))
                                                {{ $each->username_en }}
                                            @else
                                                {{ $each->firstname_en }} {{ $each->lastname_en }}
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('artist_id'))
                                <span class="form-text text-danger">{{ $errors->first('artist_id') }}</span>
                            @endif
                        </div>

                        <div class="form-group location_div">
                            <label>@lang('app.Location')</label>
                            <select name="location_id" id="location_id" class="form-control select2" data-fouc>
                                <option value="">---</option>
                                @foreach($locations as $each)
                                    @if(App::isLocale('ka'))
                                        <option @if(old('location_id') == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                    @endif
                                    @if(App::isLocale('en'))
                                        <option @if(old('location_id') == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('location_id'))
                                <span class="form-text text-danger">{{ $errors->first('location_id') }}</span>
                            @endif
                        </div>

                        <div class="form-group ">
                            <div class="custom-control custom-checkbox remeberdiv">
                                <input type="hidden" name="if_not_location" value="0" checked>
                                <input type="checkbox" class="custom-control-input" value="1" @if(old('if_not_location') == 1 ) checked @endif name="if_not_location" id="if_not_location">
                                <label class="custom-control-label" for="if_not_location">@lang('app.Location is not')</label>
                            </div>
                        </div>

                        <fieldset class="gllpLatlonPicker card-map mb-4 mt-4" style="display: none;">
                            <div  class="gllpMap">Google Maps</div>

                            @if($errors->any())
                                <input type="hidden" class="gllpLatitude" name="latitude"   value="{{ old('latitude') }}"/>
                                <input type="hidden" class="gllpLongitude" name="longitude" value="{{  old('longitude') }}"/>
                            @else
                                <input type="hidden" class="gllpLatitude" name="latitude"   value="41.7265286641925"/>
                                <input type="hidden" class="gllpLongitude" name="longitude" value="44.77328296756745"/>
                            @endif
                            <input type="hidden" class="gllpZoom" name="zoom" value="13"/>
                        </fieldset>

                    </form>

                        <label class="text-semibold mtavruli">@lang('app.Image')</label>
                        {!! Form::open(['url' => route('upload-product'), 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzone_multiple']) !!}
                        <input type="hidden" name="item_id" value="{{ $nextId }}"  />
                        <input type="hidden" name="type"  value="product" />
                        <div class="fallback">
                            <input name="file" type="file" multiple />
                        </div>
                        <div class="dropzone-previews"></div>
                        {!! Form::close() !!}
                        {!! Form::hidden('csrf-token', csrf_token(), ['id' => 'csrf-token']) !!}

                    <div class="form-group mt-5 d-flex align-items-center">
                        <button type="submit" onclick="event.preventDefault(); document.getElementById('addform').submit();"  class="btn btn-cricle ml-auto">{{ __('app.Submit') }}</button>
                    </div>


                </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('bodyend')

    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>

    <script  type="text/javascript">

        var DropzoneUploader = function() {

            var _componentDropzone = function() {

                if (typeof Dropzone == 'undefined') {
                    console.warn('Warning - dropzone.min.js is not loaded.');
                    return;
                }

                var photo_counter = 0;

                Dropzone.options.dropzoneMultiple = {
                    // paramName: "file", // The name that will be used to transfer the file
                    dictDefaultMessage: '@lang('app.Drop_Files')',
                    maxFilesize: 20,
                    addRemoveLinks: true,
                    previewsContainer: ".dropzone-previews",
                    init:function() {

                        var myDropzone = this;

                        var article_images = [ ];


                        article_images.forEach(function(image_filename) {
                            var file = {name: image_filename, size: 0};
                            myDropzone.options.addedfile.call(myDropzone, file);
                            myDropzone.emit("thumbnail", file,  '{{ asset('files/articles/small/') }}'   +"/"+image_filename);
                            myDropzone.emit("complete", file);

                            $('.serverfilename', file.previewElement).val(image_filename);
                            photo_counter++;
                            $("#photoCounter").text( "(" + photo_counter + ")");
                        });


                        this.on("removedfile", function(file) {
                            var server_file_name = $('.serverfilename', file.previewElement).val();
                            $('#addform').find('input[value="'+server_file_name+'"]').remove();

                            $.ajax({
                                type: 'POST',
                                url: '{{ asset('upload/delete') }}',
                                data: {id: server_file_name , _token: $('#csrf-token').val()},
                                dataType: 'html',
                                success: function(data){
                                    var rep = JSON.parse(data);
                                    if(rep.code == 200)
                                    {
                                        photo_counter--;
                                        $("#photoCounter").text( "(" + photo_counter + ")");
                                    }
                                }
                            });

                        } );
                    },
                    error: function(file, response) {
                        if($.type(response) === "string")
                            var message = response; //dropzone sends it's own error messages in string
                        else
                            var message = response.message;
                        file.previewElement.classList.add("dz-error");
                        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                        _results = [];
                        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                            node = _ref[_i];
                            _results.push(node.textContent = message);
                        }
                        return _results;
                    },
                    success: function(file,done) {


                        $('<input>').attr({
                            type: 'hidden',
                            class: 'serverfilename',
                            value: done.filename
                        }).appendTo(file.previewElement);

                        $('.dz-progress', file.previewElement).hide();

                        $('<input>').attr({
                            type: 'hidden',
                            name: 'images[]',
                            class: 'dinamyc_hidden_value',
                            value: done.filename
                        }).appendTo('#addform');

                        $('.serverfilename', file.previewElement).val(done.filename);
                        photo_counter++;
                        $("#photoCounter").text( "(" + photo_counter + ")");
                    }

                };

            };


            return {
                init: function() {
                    _componentDropzone();
                }
            }
        }();

        DropzoneUploader.init();

    </script>
    <script  type="text/javascript">
        var JqueryUiInteractions = function() {
            var _componentUiSortable = function() {

                if (!$().sortable) {
                    console.warn('Warning - jQuery UI components are not loaded.');
                    return;
                }

                $(".dropzone-previews").sortable({
                    change: function (event, ui) {
                        ui.placeholder.css({visibility: 'visible', border: '1px solid#337ab7' });
                        setTimeout( function(){
                            SortFormHidden();
                        }  , 1000 );
                    }
                });

                function SortFormHidden()
                {
                    $("input[class=dinamyc_hidden_value]").remove();
                    $('input[class=serverfilename]').each(function() {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'images[]',
                            class: 'dinamyc_hidden_value',
                            value:  $(this).val()
                        }).appendTo('#addform');
                    });
                }

            };

            return {
                init: function() {
                    _componentUiSortable();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            JqueryUiInteractions.init();
        });
    </script>

    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script  type="text/javascript">
       /// $('.select2').select2();
        $('.select2').select2({
              minimumResultsForSearch: Infinity
        });
        $('#if_not_location').click(function(){
            if($(this).prop("checked") == true){
                $('.card-map').show();
                $("#location_id").prop("disabled", true);
                $('#location_id option:first-child').attr("selected", true);
            }
            else if($(this).prop("checked") == false){
                $('.card-map').hide();
                $("#location_id").prop("disabled", false);
            }
        });


        CKEDITOR.replace('content', {
            height: 170,
         });

        CKEDITOR.replace('content_en', {
            height: 170,
         });


    </script>

    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBoyZK-h4o2iLmcK9vjZS5Z_JIM8uP3sR4&callback=initMap"></script>
    <script  type="text/javascript">

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


    </script>
@endsection
