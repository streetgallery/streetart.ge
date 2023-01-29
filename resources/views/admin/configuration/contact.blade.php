@extends('layouts.app')

@section('title', 'Configuration')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
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
@endsection

@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span><i class="icon-cog3"></i> @lang('app.Contact') </span> </h5>
            </div>

        </div>

    </div>

    <!-- Content area -->
    <div class="content ">

        <div class="row">

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post"  action="{{ asset('admin/contact/'. $item->id) }}" autocomplete="off">
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
                                        <input type="text" class="form-control @if ($errors->has('description')) border-danger @endif" value="{{ $item->description }}" name="description">
                                        @if ($errors->has('description'))
                                            <span class="form-text text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <textarea name="content" class="form-control" id="content" rows="4" cols="4">{{ $item->content }}</textarea>
                                        @if ($errors->has('content'))
                                            <span class="form-text text-danger">{{ $errors->first('content') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="content-en">
                                    <div class="form-group">
                                        <label>@lang('app.Name') @lang('app.Eng')</label>
                                        <input type="text" class="form-control @if ($errors->has('name_en')) border-danger @endif" value="{{ $item->name_en }}" name="name_en">
                                        @if ($errors->has('name_en'))
                                            <span class="form-text text-danger">{{ $errors->first('name_en') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('app.Description') @lang('app.Eng')</label>
                                        <input type="text" class="form-control @if ($errors->has('description_en')) border-danger @endif" value="{{ $item->description_en }}" name="description_en">
                                        @if ($errors->has('description_en'))
                                            <span class="form-text text-danger">{{ $errors->first('description_en') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <textarea name="content_en" class="form-control" id="content_en" rows="4" cols="4">{{ $item->content_en }}</textarea>
                                        @if ($errors->has('content_en'))
                                            <span class="form-text text-danger">{{ $errors->first('content_en') }}</span>
                                        @endif
                                    </div>
                                </div>

                            </div>







                            <div class="form-group">
                                <label>@lang('app.Facebook')</label>
                                <input type="text" class="form-control @if ($errors->has('facebook')) border-danger @endif" value="{{ $item->facebook }}" name="facebook">
                                @if ($errors->has('facebook'))
                                    <span class="form-text text-danger">{{ $errors->first('facebook') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label>@lang('app.Instagram')</label>
                                <input type="text" class="form-control @if ($errors->has('instagram')) border-danger @endif" value="{{ $item->instagram }}" name="instagram">
                                @if ($errors->has('instagram'))
                                    <span class="form-text text-danger">{{ $errors->first('instagram') }}</span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">@lang('app.Submit') <i class="icon-paperplane ml-2"></i></button>


                        </form>


                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <label class="text-semibold mtavruli font13">@lang('app.Image')</label>
                        {!! Form::open(['url' => route('upload-file'), 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzone_multiple']) !!}
                        <input name="item_id" type="hidden" value="{{ $item->id }}" />
                        <input name="type" type="hidden" value="contact" />
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
    <!-- /content area -->

@endsection




