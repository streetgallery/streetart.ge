@extends('layouts.site')

@section('title', '- შენი გამოფენა')
@section('title_en', '- Your Exhibition')
@section('body_class', 'exibition-body head-no-border')

@section('content')
    <div class="exhibition-page">

        @if(isset($configuration->images[0]->original))
            <img class="bgimg"  src="{{ asset($configuration->images[0]->original) }}"  />
        @endif

        <div class="exhibition-form">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="exhibition-box my-5">
                                <div>

                                    <form method="POST" class="exhibitionform" autocomplete="off" action="{{ asset('exhibition') }}" autocomplete="off">
                                        @csrf
                                        <h1>@lang('site.Your Exhibition')</h1>
 

                                        <div class="form-group">
                                            <label for="name" >{{ __('site.Exhibition Name') }}</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid1 @enderror" name="name" value="{{ old('name') }}"   autocomplete="off">
                                            @error('name')
                                                <span class="form-text text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="about_you" >{{ __('site.About you') }}</label>
                                            <textarea id="about_you" class="form-control @error('about_you') is-invalid1 @enderror" name="about_you" >{{ old('about_you') }}</textarea>
                                            @error('about_you')
                                                <span class="form-text text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="about_exhibition" >{{ __('site.About Exhibition') }}</label>
                                            <textarea id="about_exhibition" class="form-control @error('about_exhibition') is-invalid1 @enderror" name="about_exhibition" >{{ old('about_exhibition') }}</textarea>
                                            @error('about_exhibition')
                                                <span class="form-text text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="category" >{{ __('site.Category of artwork') }}</label>
                                            <input id="category" type="text" class="form-control @error('category') is-invalid1 @enderror" name="category" value="{{ old('category') }}"   autocomplete="off">
                                            @error('category')
                                                <span class="form-text text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="importent_type" >{{ __('site.How important are these types of projects?') }}</label>
                                            <textarea id="importent_type" class="form-control @error('importent_type') is-invalid1 @enderror" name="importent_type" >{{ old('importent_type') }}</textarea>
                                            @error('importent_type')
                                                <span class="form-text text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="link" >{{ __('site.Work Url') }}</label>
                                            <input id="link" type="text" class="form-control @error('link') is-invalid1 @enderror" name="link" value="{{ old('link') }}" autocomplete="off">
                                            @error('link')
                                                <span class="form-text text-danger"> {{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group reg-bottom">
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
                    </div>
            </div>
        </div>

    </div>
@endsection
@section('bodyend')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection