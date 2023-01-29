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

                    <form method="POST" class="userformaction" action="{{ asset('account/social_profiles') }}" autocomplete="off">
                        @csrf

                        <div class="form-group">
                            <label for="facebook">{{ __('Facebook') }}</label>
                            <input id="facebook" type="text" class="form-control @error('facebook') is-invalid1 @enderror" name="facebook" value="{{ Auth::user()->facebook }}">
                            @error('facebook')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="instagram">{{ __('Instagram') }}</label>
                            <input id="instagram" type="text" class="form-control @error('instagram') is-invalid1 @enderror" name="instagram" value="{{ Auth::user()->instagram }}">
                            @error('instagram')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="behance">{{ __('Behance') }}</label>
                            <input id="behance" type="text" class="form-control @error('behance') is-invalid1 @enderror" name="behance" value="{{ Auth::user()->behance }}">
                            @error('behance')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="dribbble">{{ __('Dribbble') }}</label>
                            <input id="dribbble" type="text" class="form-control @error('dribbble') is-invalid1 @enderror" name="dribbble" value="{{ Auth::user()->dribbble }}">
                            @error('dribbble')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group mt-3 d-flex align-items-center">
                            <button type="submit" class="btn mt-3 btn-cricle">{{ __('site.Update Social Profiles') }}</button>
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
