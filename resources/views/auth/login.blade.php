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
                             <form method="POST" class="login-form" autocomplete="off" action="{{ route('login') }}">
                                 <a class="logo mb-3" title="{{ config('app.name', 'ARTUP') }}" alt="{{ config('app.name', 'ARTUP') }}" href="{{ asset('') }}">
                                     @if(isset($configuration->logo))
                                         {!! $configuration->logo !!}
                                     @endif
                                 </a>
                                 @csrf
                                 <h1 class="mt-4">@lang('site.Sign In')</h1>
                                 <p>@lang("site.Don't have an account yet?") <a href="{{ route('register') }}">@lang("site.Sign Up")</a>  </p>

                                 <div class="form-group ">
                                     <label for="email">{{ __('site.Email address') }}</label>
                                     <input id="email" type="text" class="form-control @error('email') is-invalid1 @enderror" name="email" value="{{ old('email') }}" autocomplete="email" >

                                     @error('email')
                                     <span class="form-text text-danger">{{ $message }}</span>
                                     @enderror


                                 </div>

                                 <div class="form-group ">
                                     <label for="password">{{ __('site.Password') }}</label>
                                     <input id="password" type="password" class="form-control @error('password') is-invalid1 @enderror" name="password" autocomplete="current-password">

                                     @error('password')
                                     <span class="form-text text-danger">{{ $message }}</span>
                                     @enderror

                                 </div>

                                 <div class="form-group d-flex align-items-center">
                                     <div class="custom-control custom-switch">
                                         <input type="checkbox" id="remember" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }} >
                                         <label class="custom-control-label" for="remember"><span>@lang('site.Remeber')</span></label>
                                     </div>
                                     <button type="submit" class="btn btn-login ml-auto">{{ __('site.Log In') }}</button>
                                 </div>


                                 <div class="regtext">
                                     <span class="">@lang("site.Don't have an account yet?")</span>
                                 </div>

                                 <div class="form-group">
                                     <a href="{{ route('register') }}" class="btn btn-reg btn-block">{{ __('site.Sign Up') }}</a>
                                 </div>

                                 @if (Route::has('password.request'))
                                     <div class="form-group mt-3 mb-0">
                                         <a class="forgot" href="{{ route('password.request') }}">
                                             {{ __('site.Forgot Password?') }}
                                         </a>
                                     </div>
                                 @endif

                             </form>
                         <div>

                         </div>
                     </div>
                     </div>
                 </div>
             </div>
         </div>


     </div>
@endsection
