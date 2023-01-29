@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
@endsection

@section('title', '- პროფიილი')
@section('title_en', '- Profile')

@extends('layouts.site')

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include('profile.user_nav')
                </div>
                <div class="col-md-8 ">

                    <form method="POST" class="userformaction" action="{{ asset('account/profile') }}" autocomplete="off">
                        @csrf

                        <div class="form-group form-row">

                            <div class="col-md-6">
                                <label for="firstname_en">{{ __('site.First name') }}</label>
                                <input id="firstname_en" type="text" class="form-control @error('firstname_en') is-invalid1 @enderror" name="firstname_en" value="{{ Auth::user()->firstname_en }}" >
                                @error('firstname_en')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lastname_en">{{ __('site.Last name') }}</label>
                                <input id="lastname_en" type="text" class="form-control @error('lastname_en') is-invalid1 @enderror" name="lastname_en" value="{{ Auth::user()->lastname_en }}" >
                                @error('lastname_en')
                                    <span class="form-text text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username_en">{{ __('site.Nickname') }}</label>
                            <input id="username_en" type="text" class="form-control @error('username_en') is-invalid1 @enderror" name="username_en" value="{{ Auth::user()->username_en }}">
                            @error('username_en')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('site.Email address') }}</label>
                            <input id="email" type="text" class="form-control @error('email') is-invalid1 @enderror" name="email" value="{{ Auth::user()->email }}">
                            @error('email')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile">{{ __('site.Mobile') }}</label>
                            <input id="mobile" type="text" class="form-control @error('mobile') is-invalid1 @enderror" name="mobile" value="{{ Auth::user()->mobile }}">
                            @error('mobile')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website">{{ __('site.Website URL') }}</label>
                            <input id="website" type="text" class="form-control @error('website') is-invalid1 @enderror" name="website" value="{{ Auth::user()->website }}">
                            @error('website')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label for="about_en">@lang('site.Bio')</label>
                            <textarea id="about_en" rows="5" class="form-control @error('about_en') is-invalid1 @enderror" name="about_en">{{ Auth::user()->about_en }}</textarea>
                            @error('about_en')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr class="mt-5"/>
                        <h1 class="georgian-head">@lang('site.Georgian')</h1>
                        <div class="form-group form-row">
                            <div class="col-md-6">
                                <label for="firstname">{{ __('site.First name') }}</label>
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid1 @enderror" name="firstname" value="{{ Auth::user()->firstname }}" >
                                @error('firstname')
                                <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lastname">{{ __('site.Last name') }}</label>
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid1 @enderror" name="lastname" value="{{ Auth::user()->lastname }}" >
                                @error('lastname')
                                <span class="form-text text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username">{{ __('site.Nickname') }}</label>
                            <input id="username" type="text" class="form-control @error('username') is-invalid1 @enderror" name="username" value="{{ Auth::user()->username }}">
                            @error('username')
                            <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label for="about">@lang('site.Bio')</label>
                            <textarea id="about" rows="5" class="form-control @error('lastname') is-invalid1 @enderror" name="about">{{ Auth::user()->about }}</textarea>
                            @error('about')
                            <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <button type="submit" class="btn btn-cricle ml-auto">{{ __('site.Save Profile') }}</button>
                        </div>

                    </form>
                    



                </div>
            </div>
        </div>
    </section>
@endsection

@section('bodyend')
@endsection
