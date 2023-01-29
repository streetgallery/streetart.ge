@extends('layouts.app')

@section('title', '- Update User')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset("global_assets/js/plugins/forms/selects/select2.min.js") }}"></script>
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
                            myDropzone.emit("thumbnail", file,  '{{ asset('files/users/'. $item->id .'/small/') }}'   +"/"+image_filename);
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
                                url: '{{ asset('user/delete-image') }}',
                                data: {file_name: server_file_name , item_id: {{ $item->id }}, type: 'user' , _token: $('#csrf-token').val()},
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
        var addUser = function () {
            var _componentSelect2 = function () {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }
                $('.select2').select2({
                    // minimumResultsForSearch: Infinity
                });
                $('.select').select2({
                    minimumResultsForSearch: Infinity
                });

                $('.colorpicker-show-input').spectrum({
                    showInput: true
                });
            };

            var _componentUniform = function() {

                if (!$().uniform) {
                    console.warn('Warning - uniform.min.js is not loaded.');
                    return;
                }
                $('.check-styled').uniform();

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

            return {
                init: function () {
                    _componentSelect2();
                    _componentUniform();
                    _componentStates();
                    _componentCities();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function () {
            addUser.init();

        });
    </script>

    <script>


    </script>
@endsection


@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Update_User')</span> </h5>
            </div>
        </div>
    </div>

    <div class="content ">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="itemForm" action="{{ asset('admin/users/update/'. $item->id) }}">
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

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label for="firstname">@lang('app.First_Name') </label>
                                                <input id="firstname" type="text" class="form-control @error('firstname') border-danger @enderror" name="firstname" value="{{ $item->firstname }}" autocomplete="firstname" autofocus>
                                                @error('firstname')
                                                <span class="form-text text-danger">
                                            {{ $message }}
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label for="lastname">@lang('app.Last_Name')</label>
                                                <input id="lastname" type="text" class="form-control @error('lastname') border-danger @enderror" name="lastname" value="{{ $item->lastname }}" autocomplete="lastname" autofocus>
                                                @error('lastname')
                                                <span class="form-text text-danger">
                                            {{ $message }}
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="username">@lang('app.Nickname')</label>
                                        <input id="username" type="text" class="form-control @error('username') border-danger @enderror" name="username" value="{{ $item->username }}" autocomplete="off" autofocus>
                                        @error('username')
                                        <span class="form-text text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <label for="about">@lang('app.About')</label>
                                        <textarea id="about" rows="5" class="form-control @error('about') border-danger @enderror" name="about">{{ $item->about }}</textarea>
                                        @error('about')
                                        <span class="form-text text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="content-en">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label for="firstname_en">@lang('app.First_Name') <b>@lang('app.Eng')</b></label>
                                                <input id="firstname_en" type="text" class="form-control @error('firstname_en') border-danger @enderror" name="firstname_en" value="{{ $item->firstname_en }}" autocomplete="firstname_en" >
                                                @error('firstname_en')
                                                    <span class="form-text text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label for="lastname_en">@lang('app.Last_Name') <b>@lang('app.Eng')</b></label>
                                                <input id="lastname_en" type="text" class="form-control @error('lastname_en') border-danger @enderror" name="lastname_en" value="{{ $item->lastname_en }}" autocomplete="lastname_en" >
                                                @error('lastname_en')
                                                <span class="form-text text-danger">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="username_en">@lang('app.Nickname') <b>@lang('app.Eng')</b></label>
                                        <input id="username_en" type="text" class="form-control @error('username_en') border-danger @enderror" name="username_en" value="{{ $item->username_en }}" autocomplete="off" >
                                        @error('username_en')
                                        <span class="form-text text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group ">
                                        <label for="about_en">@lang('app.About') <b>@lang('app.Eng')</b></label>
                                        <textarea id="about_en" rows="5" class="form-control @error('about_en') border-danger @enderror" name="about_en">{{ $item->about_en }}</textarea>
                                        @error('about_en')
                                        <span class="form-text text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>



                            <div class="form-group ">
                                <label for="email">@lang('app.E-Mail_Address')</label>
                                <input id="email" type="email" class="form-control @error('email') border-danger @enderror" name="email" value="{{ $item->email }}"   autocomplete="email">
                                @error('email')
                                <span class="form-text text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>



                            <div class="form-group ">
                                <label for="mobile">@lang('app.Mobile')</label>
                                <input id="mobile" type="text" class="form-control @error('mobile') border-danger @enderror" name="mobile" value="{{ $item->mobile }}" autocomplete="mobile">
                                @error('mobile')
                                <span class="form-text text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="website">@lang('app.website')</label>
                                <input id="website" type="text" class="form-control @error('website') border-danger @enderror" name="website" value="{{ $item->website }}" autocomplete="website">
                                @error('website')
                                <span class="form-text text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="facebook">@lang('facebook')</label>
                                <input id="facebook" type="text" class="form-control @error('facebook') border-danger @enderror" name="facebook" value="{{ $item->facebook }}" autocomplete="facebook">
                                @error('facebook')
                                <span class="form-text text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="instagram">@lang('instagram')</label>
                                <input id="instagram" type="text" class="form-control @error('instagram') border-danger @enderror" name="instagram" value="{{ $item->instagram }}" autocomplete="instagram">
                                @error('instagram')
                                <span class="form-text text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="behance">@lang('behance')</label>
                                <input id="behance" type="text" class="form-control @error('behance') border-danger @enderror" name="behance" value="{{ $item->behance }}" autocomplete="behance">
                                @error('behance')
                                <span class="form-text text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="dribbble">@lang('dribbble')</label>
                                <input id="dribbble" type="text" class="form-control @error('dribbble') border-danger @enderror" name="dribbble" value="{{ $item->dribbble }}" autocomplete="dribbble">
                                @error('dribbble')
                                <span class="form-text text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group @if ($errors->has('group_role')) border-danger @endif" >
                                <label>@lang('app.Group') <span class="text-danger">*</span></label>
                                <select data-placeholder="---" name="group_role" class="form-control select">
                                    <option></option>
                                    <option @if($item->group_role == 'superAdmin') selected @endif value="superAdmin">@lang('app.Super_Admin')</option>
                                    <option @if($item->group_role == 'admin') selected @endif value="admin">@lang('app.Admin')</option>
                                    <option @if($item->group_role == 'user') selected @endif value="user">@lang('app.User')</option>
                                </select>
                                @if ($errors->has('group_role'))
                                    <span class="form-text text-danger">{{ $errors->first('group_role') }}</span>
                                @endif
                            </div>

                            <div class="form-group ">
                                <div class="d-inline-block">
                                    <input type="text" class="form-control colorpicker-show-input" name="bg_color" data-preferred-format="name" value="{{ $item->bg_color }}" data-fouc>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="form-check form-check-inline">
                                    <input type="hidden" name="artist" value="0" checked>
                                    <label class="form-check-label">
                                        <input type="checkbox" name="artist" value="1" class="check-styled"  @if($item->artist == 1 ) checked @endif>
                                        @lang('app.Artist')
                                    </label>
                                </div>
                            </div>

                            <div class="form-group  mb-0">
                                <button type="submit" class="btn btn-primary">
                                    @lang('app.Submit')
                                    <i class="icon-paperplane ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ asset('admin/users/updateAddress/'. $item->id) }}">
                            @csrf

                            <div class="form-group">
                                <label>@lang('app.Country') <span class="text-danger">*</span></label>
                                <select name="country_id" id="country_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                    <option value=""></option>
                                    @foreach($countries as $each)
                                        @if(App::isLocale('ka'))
                                            <option @if( $item->country_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <option @if( $item->country_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
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
                                    @foreach($states as $each)
                                        @if(App::isLocale('ka'))
                                            <option @if( $item->state_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <option @if( $item->state_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('state_id'))
                                    <span class="form-text text-danger">{{ $errors->first('state_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.City') <span class="text-danger">*</span></label>
                                <select name="city_id" id="city_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                    <option value=""></option>
                                    @foreach($cities as $each)
                                        @if(App::isLocale('ka'))
                                            <option @if( $item->city_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <option @if( $item->city_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('state_id'))
                                    <span class="form-text text-danger">{{ $errors->first('state_id') }}</span>
                                @endif
                            </div>

                            <div class="form-group  mb-0">
                                <button type="submit" class="btn btn-primary">
                                    @lang('app.Submit')
                                    <i class="icon-paperplane ml-2"></i>
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ asset('users/update/password/'. $item->id) }}">
                            @csrf

                            <div class="form-group ">
                                <label for="password" >@lang('app.Password')</label>
                                <input id="password" type="password" class="form-control @error('password') border-danger @enderror" name="password"   autocomplete="new-password">
                                @error('password')
                                <span class="form-text text-danger">
                                             {{ $message }}
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="password-confirm" >@lang('app.Confirm_Password') </label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"   autocomplete="new-password">
                            </div>

                            <div class="form-group  mb-0">
                                <button type="submit" class="btn btn-primary">
                                    @lang('app.Update_Password')
                                    <i class="icon-paperplane ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <label class="text-semibold mtavruli font13">@lang('app.Image')</label>
                        {!! Form::open(['url' => route('upload-user'), 'class' => 'dropzone', 'files'=>true, 'id'=>'dropzone_multiple']) !!}
                        <input type="hidden" name="item_id" value="{{ $item->id }}"  />
                        <input type="hidden" name="type"  value="user" />
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
