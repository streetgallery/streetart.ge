@extends('layouts.app')

@section('title', 'Update Project')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/tags/tokenfield.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/inputs/touchspin.min.js') }}"></script>

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
                    maxFilesize: 30,
                    addRemoveLinks: true,
                    previewsContainer: ".dropzone-previews",
                    init:function() {

                        var myDropzone = this;

                        var itemImages = [
                            @foreach ($item->images as $each)
                                "{{ $each->filename }}",
                            @endforeach
                        ];

                        itemImages.forEach(function(image_filename) {
                            var file = {name: image_filename, size: 0};
                            myDropzone.options.addedfile.call(myDropzone, file);
                            myDropzone.emit("thumbnail", file,  '{{ asset('files/products/'. $item->id .'/small/') }}'   +"/"+image_filename);
                            myDropzone.emit("complete", file);

                            $('<input>').attr({
                                type: 'hidden',
                                class: 'serverfilename',
                                value: image_filename
                            }).appendTo(file.previewElement);

                           // $('.serverfilename', file.previewElement).val(image_filename);
                            photo_counter++;
                            $("#photoCounter").text( "(" + photo_counter + ")");
                        });



                        this.on("removedfile", function(file) {
                            var server_file_name = $('.serverfilename', file.previewElement).val();
                            $('#itemForm').find('input[value="'+server_file_name+'"]').remove();

                            $.ajax({
                                type: 'POST',
                                url: '{{ asset('product/delete-image') }}',
                                data: {file_name: server_file_name , item_id: {{ $item->id }}, type: 'product' , _token: $('#csrf-token').val()},
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
                        }).appendTo('#itemForm');

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
                        }).appendTo('#itemForm');
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

    <script  type="text/javascript">

        var CKEditor = function() {

            var _componentCKEditor = function() {
                if (typeof CKEDITOR == 'undefined') {
                    console.warn('Warning - ckeditor.js is not loaded.');
                    return;
                }

                CKEDITOR.replace('content', {
                    height: 170,
                    filebrowserUploadUrl: "{{ asset('upload-product-content?item_id='. $item->id ) }}&_token={{ csrf_token() }}",
                    filebrowserUploadMethod: 'form'
                });

                CKEDITOR.replace('content_en', {
                    height: 170,
                    filebrowserUploadUrl: "{{ asset('upload-product-content?item_id=21'. $item->id ) }}&_token={{ csrf_token() }}",
                    filebrowserUploadMethod: 'form'
                });

            };

            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                $('.select2').select2({
                    // minimumResultsForSearch: Infinity
                });
                $('#location_id').select2({
                    // minimumResultsForSearch: Infinity
                });
            };

            var _componentSwitchery = function() {
                if (typeof Switchery == 'undefined') {
                    console.warn('Warning - switchery.min.js is not loaded.');
                    return;
                }

                var elems = Array.prototype.slice.call(document.querySelectorAll('.form-switchery'));
                elems.forEach(function(html) {
                    var switchery = new Switchery(html);
                });
            };

            var _componentTouchSpin = function() {

                $('.touchspin-qty').TouchSpin({
                    min: 0,
                    max: 999,
                    step: 1,
                    boostat: 1,
                    maxboostedstep: 1,
                    prefix: 'Qty'
                });

                $('.touchspin-price').TouchSpin({
                    min: 0,
                    max: 99999,
                    step: 0.01,
                    decimals: 2,
                    boostat: 1,
                    maxboostedstep: 1,
                    prefix: 'Gel'
                });

            };

            var _componentTokenfield = function() {
                if (!$().tokenfield) {
                    console.warn('Warning - tokenfield.min.js is not loaded.');
                    return;
                }

                $('.tokenfield').tokenfield();

            };
            var _componentUniform = function() {

                if (!$().uniform) {
                    console.warn('Warning - uniform.min.js is not loaded.');
                    return;
                }
                $('.check-styled').uniform();


            };


            var _componentIfNoLocation = function() {

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
            };



            return {
                init: function() {
                    _componentCKEditor();
                    _componentSwitchery();
                    _componentSelect2();
                    _componentTouchSpin();
                    _componentTokenfield();
                    _componentUniform();
                    _componentIfNoLocation();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            CKEditor.init();
        });
    </script>

    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBoyZK-h4o2iLmcK9vjZS5Z_JIM8uP3sR4&callback=initMap"></script>
    <script  type="text/javascript">

        var mapart = function() {
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
                    _componentMap();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            mapart.init();
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
                <h5><span>@lang('app.Update_Project') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">

        <form method="post" id="itemForm" action="{{ asset('admin/projects/update/'. $item->id) }}" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">

                            <ul class="nav nav-tabs nav-tabs-solid bg-slate border-0 nav-tabs-component rounded">
                                <li class="nav-item">
                                    <a href="#content-ka" class="nav-link active rounded-left" data-toggle="tab">
                                        <img src="{{ asset("global_assets/images/lang/ka.png") }}" class="img-flag mr-1">
                                        @lang('app.Georgian')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#content-en" class="nav-link" data-toggle="tab">
                                        <img src="{{ asset("global_assets/images/lang/en.png") }}" class="img-flag mr-1">
                                        @lang('app.English')
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="content-ka">
                                    <div class="form-group">
                                        <label>@lang('app.Name') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @if ($errors->has('name')) border-danger @endif" value="{{ $item->name }}" name="name">
                                        @if ($errors->has('name'))
                                            <span class="form-text text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <textarea name="content" class="form-control" id="content" rows="4" cols="4">{{ $item->content }}</textarea>
                                </div>

                                <div class="tab-pane fade" id="content-en">
                                    <div class="form-group">
                                        <label>@lang('app.Name') <b>@lang('app.Eng')</b>  </label>
                                        <input type="text" class="form-control @if ($errors->has('name_en')) border-danger @endif" value="{{ $item->name_en }}" name="name_en">
                                        @if ($errors->has('name_en'))
                                            <span class="form-text text-danger">{{ $errors->first('name_en') }}</span>
                                        @endif
                                    </div>
                                    <textarea name="content_en" class="form-control" id="content_en" rows="4" cols="4">{{ $item->content_en }}</textarea>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card card-map " @if($item->if_not_location != 1 ) style="display: none;" @endif>
                        <div class="card-body">
                            <fieldset class="gllpLatlonPicker">
                                <div  class="gllpMap">Google Maps</div>
                                <input type="hidden" class="gllpLatitude" name="latitude"   value="{{ $item->latitude }}"/>
                                <input type="hidden" class="gllpLongitude" name="longitude" value="{{ $item->longitude }}"/>
                                <input type="hidden" class="gllpZoom" name="zoom" value="13"/>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label>@lang('app.Category') <span class="text-danger">*</span></label>
                                <select name="category_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                    <option value=""></option>
                                    @foreach($categories as $each)
                                        @if(App::isLocale('ka'))
                                            <option @if($item->category_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <option @if($item->category_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="form-text text-danger">{{ $errors->first('category_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Artist') <span class="text-danger">*</span></label>
                                <select name="artist_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                    <option value=""></option>
                                    @foreach($artists as $each)
                                        <option @if($item->artist_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->lastname }} {{ $each->firstname }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('artist_id'))
                                    <span class="form-text text-danger">{{ $errors->first('artist_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group location_div">
                                <label>@lang('app.Location')</label>
                                <select name="location_id" id="location_id" @if($item->if_not_location == 1 ) disabled @endif  class="form-control" data-fouc>
                                    <option value="">---</option>
                                    @foreach($locations as $each)
                                        @if(App::isLocale('ka'))
                                            <option @if($item->location_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <option @if($item->location_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('location_id'))
                                    <span class="form-text text-danger">{{ $errors->first('location_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group " style="margin-top: 37px">
                                <div class="form-check form-check-inline">
                                    <input type="hidden" name="if_not_location" value="0" checked>
                                    <label class="form-check-label">
                                        <input type="checkbox" name="if_not_location" id="if_not_location" value="1" class="check-styled" @if($item->if_not_location == 1 ) checked @endif>
                                        @lang('app.Location is not')
                                    </label>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-solid bg-slate border-0 nav-tabs-component rounded">
                                <li class="nav-item">
                                    <a href="#seo-ka" class="nav-link active rounded-left" data-toggle="tab">
                                        <img src="{{ asset("global_assets/images/lang/ka.png") }}" class="img-flag mr-1">
                                        @lang('app.Georgian')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#seo-en" class="nav-link" data-toggle="tab">
                                        <img src="{{ asset("global_assets/images/lang/en.png") }}" class="img-flag mr-1">
                                        @lang('app.English')
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="seo-ka">
                                    <div class="form-group">
                                        <label>@lang('app.Meta_Keywords') </label>
                                        <input type="text" class="form-control tokenfield @if ($errors->has('keywords')) border-danger @endif" value="{{ $item->keywords  }}" name="keywords">
                                        @if ($errors->has('keywords'))
                                            <span class="form-text text-danger">{{ $errors->first('keywords') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('app.Meta_Description')</label>
                                        <textarea name="description" class="form-control @if ($errors->has('description')) border-danger @endif" rows="4" cols="4">{{ $item->description  }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="form-text text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="seo-en">

                                    <div class="form-group">
                                        <label>@lang('app.Meta_Keywords') <b>@lang('app.Eng')</b>  </label>
                                        <input type="text" class="form-control tokenfield @if ($errors->has('keywords_en')) border-danger @endif" value="{{ $item->keywords_en  }}" name="keywords_en">
                                        @if ($errors->has('keywords_en'))
                                            <span class="form-text text-danger">{{ $errors->first('keywords_en') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('app.Meta_Description') <b>@lang('app.Eng')</b>  </label>
                                        <textarea name="description_en" class="form-control @if ($errors->has('description_en')) border-danger @endif" rows="4" cols="4">{{ $item->description_en }}</textarea>
                                        @if ($errors->has('description_en'))
                                            <span class="form-text text-danger">{{ $errors->first('description_en') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body d-flex">

                            <div class="form-check form-check-switchery switchery-sm mt-1 mr-auto">
                                <label class="form-check-label">
                                    <input type="hidden" name="status" checked value="0">
                                    <input type="checkbox" name="status" @if($item->status == 1 ) checked @endif value="1" class="form-switchery" >
                                    @lang('app.Status')
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">@lang('app.Submit') <i class="icon-paperplane ml-2"></i></button>

                        </div>
                    </div>

                </div>
            </div>
        </form>


        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <label class="text-semibold mtavruli font13">@lang('app.Image')</label>
                        {!! Form::open(['url' => route('upload-product'), 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzone_multiple']) !!}
                            <input type="hidden" name="item_id" value="{{ $item->id }}"  />
                            <input type="hidden" name="type"  value="product" />
                            <div class="fallback">
                                 <input name="file" type="file" multiple />
                            </div>
                            <div class="dropzone-previews"></div>
                        {!! Form::close() !!}
                        {!! Form::hidden('csrf-token', csrf_token(), ['id' => 'csrf-token']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('bodyend')




@endsection
