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
                <div class="col-md-8">

                    <form method="POST" class="userformaction" action="{{ asset('account/password') }}" autocomplete="off">

                        @csrf

                        <div class="form-group">
                            <label for="old_password">{{ __('site.Old Password') }}</label>
                            <input id="old_password" type="text" class="form-control @error('old_password') is-invalid1 @enderror" name="old_password" value="">
                            @error('old_password')
                            <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">{{ __('site.Password') }}</label>
                            <input id="new_password" type="text" class="form-control @error('new_password') is-invalid1 @enderror" name="new_password" value="">
                            @error('new_password')
                            <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
 

                        <div class="form-group mt-3 d-flex align-items-center">
                            <button type="submit" class="btn mt-3 btn-cricle">{{ __('site.Change') }}</button>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('bodyend')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
