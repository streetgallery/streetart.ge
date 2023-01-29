@extends('layouts.site')


@section('head')

    <meta property="og:url" content="{{ asset('article') }}/{{ $item->id }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="artup" />
    <meta property="article:publisher" content="artup" />

    @if(App::isLocale('ka'))

        @if(isset($item->description))
            <meta name="description" content="{{ $item->description }}">
        @endif

        @if(isset($item->keywords))
            <meta name="keywords" content="{{ $item->keywords }}">
        @endif

        @if(isset($item->name_en))
            <meta property="og:title" content="{{ $item->name }}" />
        @endif

        @if(isset($item->description))
            <meta property="og:description" content="{{ $item->description }}" />
        @endif

    @endif
    @if(App::isLocale('en'))

        @if(isset($item->description_en))
            <meta name="description" content="{{ $item->description_en }}">
        @endif

        @if(isset($item->keywords_en))
            <meta name="keywords" content="{{ $item->keywords_en }}">
        @endif

        @if(isset($item->name_en))
            <meta property="og:title" content="{{ $item->name_en }}" />
        @endif
        @if(isset($item->description_en))
            <meta property="og:description" content="{{ $item->description_en }}" />
        @endif
    @endif

    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="620" />
    <meta property="og:image:height" content="541" />

    @if(isset($item->images[0]->medium))
        <meta property="og:image" content="{{ asset($item->images[0]->medium) }}" />
    @endif




@endsection


@section('content')

    <section class="blog-article">
        <div class="container">
            <div class="row">
                <div class="col-12" >
                    <div class="article-single">
                      <!--  <div class="backdiv"><a class="backarticle"  onclick="goBack()" href="#back"><i class="back"></i>@lang('site.Back')</a></div>
-->
                        @if(App::isLocale('ka'))
                            <h1>{{ $item->name }}</h1>
                        @endif

                        @if(App::isLocale('en'))
                            <h1>{{ $item->name_en }}</h1>
                        @endif

                        @if(isset($item->images[0]->medium))
                            <div class="article-img">
                                <img src="{{ asset($item->images[0]->medium) }}">
                            </div>
                        @endif



                        @if(App::isLocale('ka'))
                            <div>{!! $item->content !!}</div>
                        @endif

                        @if(App::isLocale('en'))
                            <div>{!! $item->content_en !!}</div>
                        @endif


                         <div class="share-art mt-5">
                            <span>@lang('site.Share'):</span>
                            <ul>
                                <li>
                                    <a class="facebook" target="_blank" href="{{ asset('article/'. $item->id ) }}" onclick="share();">
                                        <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"></path></svg>
                                    </a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection



@section('bodystart')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0" nonce="grH6Aqme"></script>
@endsection

@section('bodyend')

    <script type="text/javascript">

        function share() {
            var width = 626;
            var height = 436;
            var PageToShare = location.href;
            var sharerUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(PageToShare);
            var l = window.screenX + (window.outerWidth - width) / 2;
            var t = window.screenY + (window.outerHeight - height) / 2;
            var winProps = ['width='+width,'height='+height,'left='+l,'top='+t,'status=no','resizable=yes','toolbar=no','menubar=no','scrollbars=yes'].join(',');
            var win = window.open(sharerUrl, 'fbShareWin', winProps);
        }

    </script>

    <script type="text/javascript">
        var id = {{ $id }};

        $(document).ready(function() {
            $.ajax({
                type : 'GET',
                url: "{{ asset('') }}api/article/" + id ,
                success : function(data){

                    if(data.length == 0){

                    }else{
                        $('#loadArticle').append(data.html);
                    }
                },error: function(data){

                },
            })
        });


    </script>

    <script>


        if (document.referrer == "") {
            $( ".backdiv" ).hide();
        }

        function goBack() {
            window.history.back();
        }

    </script>
@endsection
