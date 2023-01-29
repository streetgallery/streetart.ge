@extends('layouts.app')

@section('title', 'Add Navigation')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script  type="text/javascript">
        var select = function() {
            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }
                $('.select2').select2({
                    minimumResultsForSearch: Infinity
                });
            };
            return {
                init: function() {
                    _componentSelect2();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            select.init();
        });
    </script>

@endsection


@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Add_Navigation') </span> </h5>
            </div>
        </div>
    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body">
                        <form method="post" id="itemForm" action="{{ asset('admin/navigation/add') }}" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>@lang('app.Name') </label>
                                <input type="text" class="form-control @if ($errors->has('name')) border-danger @endif" value="{{ old('name') }}" name="name">
                                @if ($errors->has('name'))
                                    <span class="form-text text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>@lang('app.Name') <b>@lang('app.Eng')</b></label>
                                <input type="text" class="form-control @if ($errors->has('name_en')) border-danger @endif" value="{{ old('name_en') }}" name="name_en">
                                @if ($errors->has('name_en'))
                                    <span class="form-text text-danger">{{ $errors->first('name_en') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label>@lang('app.Link') </label>
                                <input type="text" class="form-control @if ($errors->has('link')) border-danger @endif" value="{{ old('link') }}" name="link">
                                @if ($errors->has('link'))
                                    <span class="form-text text-danger">{{ $errors->first('link') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Sort')</label>
                                <input type="number" class="form-control @if ($errors->has('sort')) border-danger @endif" value="{{ old('sort') }}" name="sort">
                                @if ($errors->has('sort'))
                                    <span class="form-text text-danger">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Navigation')</label>
                                <select name="navigation" id="navigation" class="form-control select2" data-fouc>
                                    <option @if( old('navigation') == "main") selected @endif value="main">@lang('app.Main')</option>
                                    <option @if( old('navigation') == "top") selected @endif value="top">@lang('app.Top')</option>
                                    <option @if( old('navigation') == "bottom") selected @endif value="bottom">@lang('app.Bottom')</option>
                                </select>
                                @if ($errors->has('navigation'))
                                    <span class="form-text text-danger">{{ $errors->first('navigation') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Parent')</label>
                                <select name="parent_id" id="parent_id"   class="form-control select2" data-fouc>
                                    <option value="0">---</option>
                                    @foreach($navigation as $each)
                                        @if(App::isLocale('ka'))
                                            <option @if( old('parent_id') == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <option @if( old('parent_id') == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('parent_id'))
                                    <span class="form-text text-danger">{{ $errors->first('parent_id') }}</span>
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
