@extends('layouts.app')

@section('title', 'Update Slide')

@section('head')

@endsection

@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Update_Exhibition') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body">
                        <form method="post" id="itemForm" action="{{ asset('admin/exhibitions/update/'. $item->id) }}" autocomplete="off">
                            @csrf

                            <div class="form-group">
                                <label for="name" >{{ __('site.Exhibition Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid1 @enderror" name="name" value="{{ $item->name }}"   autocomplete="off">
                                @error('name')
                                <span class="form-text text-danger"> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="about_you" >{{ __('site.About you') }}</label>
                                <textarea id="about_you" class="form-control @error('about_you') is-invalid1 @enderror" name="about_you" >{{ $item->about_you }}</textarea>
                                @error('about_you')
                                <span class="form-text text-danger"> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="about_exhibition" >{{ __('site.About Exhibition') }}</label>
                                <textarea id="about_exhibition" class="form-control @error('about_exhibition') is-invalid1 @enderror" name="about_exhibition" >{{ $item->about_exhibition }}</textarea>
                                @error('about_exhibition')
                                <span class="form-text text-danger"> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category" >{{ __('site.Category of artwork') }}</label>
                                <input id="category" type="text" class="form-control @error('category') is-invalid1 @enderror" name="category" value="{{ $item->category }}"   autocomplete="off">
                                @error('category')
                                <span class="form-text text-danger"> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="importent_type" >{{ __('site.How important are these types of projects?') }}</label>
                                <textarea id="importent_type" class="form-control @error('importent_type') is-invalid1 @enderror" name="importent_type" >{{ $item->importent_type }}</textarea>
                                @error('importent_type')
                                <span class="form-text text-danger"> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="link" >{{ __('site.Work Url') }}</label>
                                <input id="link" type="text" class="form-control @error('link') is-invalid1 @enderror" name="link" value="{{ $item->link }}" autocomplete="off">
                                @error('link')
                                <span class="form-text text-danger"> {{ $message }}</span>
                                @enderror
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
