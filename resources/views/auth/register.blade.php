@extends('layouts.auth')
@section('title', '- Sign Up')


@section('content')
    <div class="auth-form">

        @if(isset($configuration->images[0]->original))
            <img class="bgimg"  src="{{ asset($configuration->images[0]->original) }}"  />
        @endif

        <div class="auth-grid">
            <div class="container">
                <div class="row">

                    <div class="col-xl-12">
                        <div class="login-box">
                            <form method="POST" class="login-form" autocomplete="off" action="{{ route('register') }}" autocomplete="off">
                                <a class="logo mb-3" title="{{ config('app.name', 'ARTUP') }}" alt="{{ config('app.name', 'ARTUP') }}" href="{{ asset('') }}">
                                    @if(isset($configuration->logo))
                                        {!! $configuration->logo !!}
                                    @endif
                                </a>
                                @csrf
                                <h1 class="mt-4">@lang('site.Create account')</h1>
                                <p>@lang("site.Already have an account?") <a href="{{ route('login') }}">@lang("site.Sign In")</a>  </p>


                                <div class="form-group form-row">

                                    <div class="col-md-6">
                                        <label for="firstname">{{ __('site.First name') }}</label>
                                        <input id="firstname" type="text" class="form-control @error('firstname') is-invalid1 @enderror" name="firstname" value="{{ old('firstname') }}"   autocomplete="off" autofocus>
                                        @error('firstname')
                                            <span class="form-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="lastname">{{ __('site.Last name') }}</label>
                                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid1 @enderror" name="lastname" value="{{ old('lastname') }}"   autocomplete="off" autofocus>
                                        @error('lastname')
                                            <span class="form-text text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" >{{ __('site.Email address') }}</label>
                                        <input id="email" type="text" class="form-control @error('email') is-invalid1 @enderror" name="email" value="{{ old('email') }}"   autocomplete="off">
                                        @error('email')
                                            <span class="form-text text-danger"> {{ $message }}</span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ __('site.Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid1 @enderror" name="password" autocomplete="off">
                                    @error('password')
                                        <span class="form-text text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
 
                                <div class="form-group">
                                    <label for="password-confirm">{{ __('site.Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="off">
                                 </div>

                                <div class="form-group reg-bottom mb-0">
                                    <div class="">
                                        <div class="g-recaptcha" data-sitekey="6LfwuN8ZAAAAAAjgrBf6uo3g06rkkjuGyADfl3bk"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="form-text text-danger"> {{ $errors->first('g-recaptcha-response') }}</span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-login ml-auto">{{ __('site.Sign Up') }}</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('bodyend')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

