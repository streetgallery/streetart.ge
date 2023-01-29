@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
@endsection

@section('title', '- კონტაქტი')
@section('title_en', '- Contact')

@extends('layouts.site')

@section('content')

    <section class="contact-section-header pt-5"  >

        <div class="container">
            <div class="row">
                <div class="col-lg-6">

                    <div class="center-vertical">
                        <div class="w-100">
                            @if(App::isLocale('ka'))
                                <h1>{{ $contact->name }}</h1>
                                <div>{{ $contact->content }}</div>
                            @endif

                            @if(App::isLocale('en'))
                                <h1>{{ $contact->name_en }}</h1>
                                <div>{{ $contact->content_en }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    @if(isset($contact->images[0]))
                        <div>
                            <img src="{{ asset($contact->images[0]->original) }}" class="w-100">
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </section>

    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" class="login-form contact-form" autocomplete="off" action="{{ asset('contact') }}" autocomplete="off">
                        @csrf
                        @if(App::isLocale('ka'))
                            <p>{!! $contact->description !!} </p>
                        @endif

                        @if(App::isLocale('en'))
                            <p>{!! $contact->description_en !!} </p>
                        @endif

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
                            <input id="email" type="text" col="6" class="form-control @error('email') is-invalid1 @enderror" name="email" value="{{ old('email') }}"   autocomplete="off">
                            @error('email')
                            <span class="form-text text-danger"> {{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="message" >{{ __('site.Message') }}</label>
                            <textarea id="message" class="form-control @error('message') is-invalid1 @enderror" name="message" ></textarea>
                            @error('message')
                            <span class="form-text text-danger"> {{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group d-flex align-items-center">
                            <div class="">
                                <div class="g-recaptcha" data-sitekey="6LfwuN8ZAAAAAAjgrBf6uo3g06rkkjuGyADfl3bk"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="form-text text-danger"> {{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-login ml-auto">{{ __('site.Send') }}</button>
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
