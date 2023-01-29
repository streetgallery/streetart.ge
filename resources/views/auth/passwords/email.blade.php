@extends('layouts.auth')
@section('title', '- Reset Password')



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
                        <div>
                            <div class="logo-box">
                                <form method="POST" class="login-form reset-form" action="{{ route('password.email') }}"  style="min-height: unset !important;" autocomplete="off">
                                    @csrf
                                    <a class="logo mb-3" title="{{ config('app.name', 'ARTUP') }}" alt="{{ config('app.name', 'ARTUP') }}" href="{{ asset('') }}">
                                        @if(isset($configuration->logo))
                                            {!! $configuration->logo !!}
                                        @endif
                                    </a>
                                    <h1 class="mt-4">@lang('site.Reset Password')</h1>


                                    <p> <a class="p-0" href="{{ route('login') }}">@lang("site.Sign In")</a>  </p>


                                    <div class="form-group">

                                        <label for="email" >{{ __('site.Email address') }}</label>

                                        <input id="email" type="text" class="form-control @error('email') is-invalid1 @enderror" name="email" value="{{ old('email') }}"   autocomplete="off"  >

                                        @error('email')
                                        <span class="form-text text-danger"> {{ $message }}</span>
                                        @enderror

                                    </div>


                                    <div class="form-group d-flex align-items-center">
                                        <button type="submit" class="btn btn-login ml-auto">{{ __('site.Send Password Reset Link') }}</button>
                                    </div>


                                </form>
                            </div>


                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('bodyend')


@endsection



@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
