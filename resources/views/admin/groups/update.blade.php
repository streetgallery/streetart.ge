@extends('layouts.app')

@section('title', 'Update Group')

@section('head')

@endsection

@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Update_Group') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ asset('admin/groups/update/'. $item->id) }}">
                            @csrf
                            <div class="form-group">
                                <label>@lang('app.Name')</label>
                                <input type="text" class="form-control @if ($errors->has('name')) border-danger @endif" value="{{ $item->name }}" name="name">
                                @if ($errors->has('name'))
                                    <span class="form-text text-danger">{{ $errors->first('name') }}</span>
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
