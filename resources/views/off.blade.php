@extends('layouts.auth')
@section('title', '- Sign Up')


@section('content')
    <div class="off-page">

        @if(isset($configuration->images[0]->original))
            <img class="bgimg"  src="{{ asset($configuration->images[0]->original) }}"  />
        @endif
        <div class="auth-grid">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="off">
                            @lang('site.Comming Soon')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

