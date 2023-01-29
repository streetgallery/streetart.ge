@extends('layouts.auth')

@section('head')

@endsection

@section('title', '- Sign In')



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
                            <form method="POST" method="POST" class="login-form" autocomplete="off" action="{{ route('password.update') }}" style="min-height: unset !important;" >
                                @csrf

                                <h1 class="mt-4">@lang('site.Reset Password')</h1>
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group ">
                                    <label for="email" >{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label for="password" >{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" >{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="form-group  mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('site.Reset Password') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

