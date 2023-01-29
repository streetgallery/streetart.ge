@extends('layouts.app')

@section('title', 'Add Category')

@section('head')

@endsection


@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Add_Category') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body">
                        <form method="post" id="itemForm" action="{{ asset('admin/articles/categories/add') }}" autocomplete="off">
                            @csrf
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
