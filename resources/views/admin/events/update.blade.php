@extends('layouts.app')

@section('title', 'Update Event')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/tags/tokenfield.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/inputs/touchspin.min.js') }}"></script>

    <script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
 
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
                    maxFilesize: 5,
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
                            myDropzone.emit("thumbnail", file,  '{{ asset('files/events/'. $item->id .'/small/') }}'   +"/"+image_filename);
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
                                url: '{{ asset('event/delete-image') }}',
                                data: {file_name: server_file_name , item_id: {{ $item->id }} , _token: $('#csrf-token').val()},
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
                    height: 368,
                    filebrowserUploadUrl: "{{ asset('upload-event-content?item_id='. $item->id ) }}&_token={{ csrf_token() }}",
                    filebrowserUploadMethod: 'form'
                });

                CKEDITOR.replace('content_en', {
                    height: 368,
                    filebrowserUploadUrl: "{{ asset('upload-event-content?item_id=21'. $item->id ) }}&_token={{ csrf_token() }}",
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


             var _componentDaterange = function() {
                if (!$().daterangepicker) {
                    console.warn('Warning - daterangepicker.js is not loaded.');
                    return;
                }

                 $('.daterange-single').daterangepicker({
                     timePicker: true,
                     timePicker24Hour: true,
                     singleDatePicker: true,
                     showDropdowns: true,
                     locale: {
                         format: 'YYYY-MM-DD HH:mm:ss',
                         firstDay: 1
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
                    _componentDaterange();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            CKEditor.init();
        });

    </script>
@endsection

@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Update_Event') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">

        <form method="post" id="itemForm" action="{{ asset('admin/events/update/'. $item->id) }}" autocomplete="off">
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
                                        <label>@lang('app.Name') </label>
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
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label>@lang('site.Date'):</label>
                                <input type="text" name="event_date" value="{{ $item->event_date }}" class="form-control daterange-single" >
                             </div>


                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" class="form-control @if ($errors->has('facebook')) border-danger @endif" value="{{ $item->facebook }}" name="facebook">
                                @if ($errors->has('facebook'))
                                    <span class="form-text text-danger">{{ $errors->first('facebook') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Instagram</label>
                                <input type="text" class="form-control @if ($errors->has('instagram')) border-danger @endif" value="{{ $item->instagram }}" name="instagram">
                                @if ($errors->has('instagram'))
                                    <span class="form-text text-danger">{{ $errors->first('instagram') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Youtube</label>
                                <input type="text" class="form-control @if ($errors->has('youtube')) border-danger @endif" value="{{ $item->youtube }}" name="youtube">
                                @if ($errors->has('youtube'))
                                    <span class="form-text text-danger">{{ $errors->first('youtube') }}</span>
                                @endif
                            </div>



                            <div class="form-group">
                                <label>@lang('app.Artists')</label>
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


                            <div class="form-group">
                                <label>@lang('app.Locations')</label>
                                <select name="location_id[]" multiple="multiple" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                    <option value=""></option>

                                    @foreach($locations as $each)
                                        @if(App::isLocale('ka'))
                                            <option @if(in_array($each->id, $arrayLocation)) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <option @if(in_array($each->id, $arrayLocation)) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('artist_id'))
                                    <span class="form-text text-danger">{{ $errors->first('artist_id') }}</span>
                                @endif
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
                                <input type="hidden" name="status" checked value="0">

                                <label class="form-check-label">
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

                        {!! Form::open(['url' => route('upload-event'), 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzone_multiple']) !!}
                            <input type="hidden" name="item_id" value="{{ $item->id }}"  />
                            <input type="hidden" name="type"  value="event" />
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
