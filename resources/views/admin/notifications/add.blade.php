@extends('layouts.app')

@section('title', 'Add Notification')

@section('head')

@endsection


@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span> @lang('app.Add_Notification') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ asset('notifications/add') }}">
                            @csrf

                            <div class="form-group">
                                <label> @lang('app.Comment')  <span class="text-danger">*</span></label>
                                <textarea rows="3" cols="3" name="comment" class="form-control @if ($errors->has('comment')) border-danger @endif" >{{ old('comment') }}</textarea>
                                @if ($errors->has('comment'))
                                    <span class="form-text text-danger">{{ $errors->first('comment') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Client_ID')   <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @if ($errors->has('client_id')) border-danger @endif" value="{{ old('client_id') }}" name="client_id">
                                @if ($errors->has('client_id'))
                                    <span class="form-text text-danger">{{ $errors->first('client_id') }}</span>
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
