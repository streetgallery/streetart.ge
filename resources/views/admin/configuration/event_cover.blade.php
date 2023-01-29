@extends('layouts.app_mini')

@section('title', 'Configuration')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
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
                            @foreach ($item->event_cover as $each)
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

        var CKEditor = function() {

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

            return {
                init: function() {
                    _componentSwitchery();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            CKEditor.init();
        });
    </script>

@endsection

@section('content')

    <!-- Content area -->
    <div class="content ">

        <div class="row">

            <div class="col-xl-6">
                <div class=" ">
                    <div class=" "> 
                        {!! Form::open(['url' => route('upload-file'), 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzone_multiple']) !!}
                        <input name="item_id" type="hidden" value="1" />
                        <input name="type" type="hidden" value="event_cover" />
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









