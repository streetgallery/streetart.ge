@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
@endsection

@section('title', '- პროფიილის ავატარი')
@section('title_en', '- Avatar Profile')

@extends('layouts.site')

@section('content')


    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include('profile.user_nav')
                </div>
                <div class="col-md-8">
                    <form method="POST" class="userformaction" action="{{ asset('upload-avatar') }}" accept-charset="UTF-8"  enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="sort" value="1"  />
                        <input type="hidden" name="item_id" value="{{ $item->id }}"  />
                        <input type="hidden" name="type"  value="user" />
                        <input type="hidden" name="profile"  value="avatar" />

                        <input type="file"  accept="image/*" name="file" id="file"  onchange="loadFile(event)"  style="display: none" >

                        <label class="upload_avatar"  for="file" style="cursor: pointer;" >
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.056 512.056" style="enable-background:new 0 0 512.056 512.056;" xml:space="preserve"><g><g><g><path d="M426.635,188.224C402.969,93.946,307.358,36.704,213.08,60.37C139.404,78.865,85.907,142.542,80.395,218.303 C28.082,226.93-7.333,276.331,1.294,328.644c7.669,46.507,47.967,80.566,95.101,80.379h80v-32h-80c-35.346,0-64-28.654-64-64 c0-35.346,28.654-64,64-64c8.837,0,16-7.163,16-16c-0.08-79.529,64.327-144.065,143.856-144.144 c68.844-0.069,128.107,48.601,141.424,116.144c1.315,6.744,6.788,11.896,13.6,12.8c43.742,6.229,74.151,46.738,67.923,90.479 c-5.593,39.278-39.129,68.523-78.803,68.721h-64v32h64c61.856-0.187,111.848-50.483,111.66-112.339 C511.899,245.194,476.655,200.443,426.635,188.224z"/><path d="M245.035,253.664l-64,64l22.56,22.56l36.8-36.64v153.44h32v-153.44l36.64,36.64l22.56-22.56l-64-64 C261.354,247.46,251.276,247.46,245.035,253.664z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        @if(isset(Auth::user()->images[0]->small))
                                <img id="output" src="{{ asset(Auth::user()->images[0]->small) }}"  />
                                <a  href="#delete-avatar" onclick="event.preventDefault(); document.getElementById('delete-avatar').submit();" class="btn remove-avatar">×</a>

                            @else
                                <img id="output" width="200" style="display: none"/>
                            @endif
                        </label>

                        <div class="form-group mt-3 d-flex align-items-center">
                        <!-- <button type="submit" class="btn btn-cricle">{{ __('site.Upload Avatar') }}</button>-->
                            @if(isset(Auth::user()->images[0]->small))
                                 <label href="#delete-avatar" for="file" class="btn btn-cricle">{{ __('site.Upload new avatar') }}</label>
                                <!--<a href="#delete-avatar" onclick="event.preventDefault(); document.getElementById('delete-avatar').submit();" class="btn btn-cricle-grey ml-2">{{ __('site.Delete') }}</a>-->
                            @endif
                        </div>

                    </form>

                    <form method="POST" id="delete-avatar" action="{{ asset('delete-avatar') }}">
                        @csrf
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('bodyend')
    <script>
        var loadFile = function(event) {
            $('.upload_avatar img').show();
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            $('.userformaction').submit();

        };
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endsection
