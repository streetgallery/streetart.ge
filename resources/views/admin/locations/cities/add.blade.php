@extends('layouts.app')

@section('title', 'Add City')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
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



            return {
                init: function() {
                    _componentSelect2();
                    _componentStates();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            country.init();
        });
    </script>

@endsection


@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Add_City') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body">
                        <form method="post" id="itemForm" action="{{ asset('admin/cities/add') }}" autocomplete="off">
                            @csrf

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
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('bodyend')

@endsection
