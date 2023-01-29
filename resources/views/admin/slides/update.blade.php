@extends('layouts.app')

@section('title', 'Update Slide')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset("global_assets/js/plugins/pickers/color/spectrum.js") }}"></script>

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
                            myDropzone.emit("thumbnail", file,  '{{ asset('files/articles/small/') }}'   +"/"+image_filename);
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
        var Slide = function () {
            var _componentColor= function () {

                $('.colorpicker-show-input').spectrum({
                    showInput: true,
                    showAlpha: true,
                    allowEmpty: true
                });
            };

            return {
                init: function () {
                    _componentColor();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function () {
            Slide.init();
        });
    </script>

@endsection

@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Update_Slide') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body">
                        <form method="post" id="itemForm" action="{{ asset('admin/slides/update/'. $item->id) }}" autocomplete="off">
                            @csrf

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
                                        <label>@lang('app.Name')</label>
                                        <input type="text" class="form-control @if ($errors->has('name')) border-danger @endif" value="{{ $item->name }}" name="name">
                                        @if ($errors->has('name'))
                                            <span class="form-text text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('app.Description')</label>
                                        <textarea name="description" class="form-control @if ($errors->has('description')) border-danger @endif" rows="4" cols="4">{{ $item->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="form-text text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <label>@lang('app.Button')</label>
                                        <input type="text" class="form-control @if ($errors->has('button')) border-danger @endif" value="{{ $item->button }}" name="button">
                                        @if ($errors->has('button'))
                                            <span class="form-text text-danger">{{ $errors->first('button') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="content-en">


                                    <div class="form-group">
                                        <label>@lang('app.Name') <b>@lang('app.Eng')</b></label>
                                        <input type="text" class="form-control @if ($errors->has('name_en')) border-danger @endif" value="{{ $item->name_en }}{{ old('') }}" name="name_en">
                                        @if ($errors->has('name_en'))
                                            <span class="form-text text-danger">{{ $errors->first('name_en') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('app.Description') <b>@lang('app.Eng')</b>  </label>
                                        <textarea name="description_en" class="form-control @if ($errors->has('description_en')) border-danger @endif" rows="4" cols="4">{{ $item->description_en }}</textarea>
                                        @if ($errors->has('description_en'))
                                            <span class="form-text text-danger">{{ $errors->first('description_en') }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <label>@lang('app.Button') <b>@lang('app.Eng')</b></label>
                                        <input type="text" class="form-control @if ($errors->has('button_en')) border-danger @endif" value="{{ $item->button_en }}" name="button_en">
                                        @if ($errors->has('button_en'))
                                            <span class="form-text text-danger">{{ $errors->first('button_en') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>


                            <div class="form-group ">
                                <label>@lang('app.Color')</label>
                                <div class="d-inline-block">
                                    <input type="text" class="form-control colorpicker-show-input" name="color" data-preferred-format="rgb" value="{{ $item->color }}" data-fouc>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label>@lang('app.Background Color')</label>
                                <div class="d-inline-block">
                                    <input type="text" class="form-control colorpicker-show-input" name="bg_color" data-preferred-format="rgb" value="{{ $item->bg_color }}" data-fouc>
                                </div>
                            </div>





                            <div class="form-group">
                                <label>@lang('app.Link')   </label>
                                <input type="text" class="form-control @if ($errors->has('link')) border-danger @endif" value="{{ $item->link }}" name="link">
                                @if ($errors->has('link'))
                                    <span class="form-text text-danger">{{ $errors->first('link') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Sort')</label>
                                <input type="number" class="form-control @if ($errors->has('sort')) border-danger @endif" value="{{ $item->sort }}" name="sort">
                                @if ($errors->has('sort'))
                                <span class="form-text text-danger">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>


                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">@lang('app.Submit') <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>


                    </div>
                </div>




                <div class="card">
                    <div class="card-body">
                        <label class="text-semibold mtavruli font13">@lang('app.Image')</label>
                        {!! Form::open(['url' => route('upload-file'), 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzone_multiple']) !!}
                        <input name="item_id" type="hidden" value="{{ $item->id }}" />
                        <input name="type" type="hidden" value="slide" />
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
