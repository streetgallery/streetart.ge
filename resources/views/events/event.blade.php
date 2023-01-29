@extends('layouts.site')

@section('head')

    <meta property="og:url" content="{{ asset('exhibition') }}/{{ $item->id }}" />
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
                    <div class="article-single" id="loadEvent"></div>
                </div>
            </div>
        </div>
    </section>


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

    <script>
        if (document.referrer == "") {
            $( ".backdiv" ).hide();
        }

        function goBack() {
            window.history.back();
        }

    </script>
    <script type="text/javascript">
        var id = {{ $id }};

        $(document).ready(function() {
            $.ajax({
                type : 'GET',
                url: "{{ asset('') }}api/event/" + id ,
                success : function(data){

                    if(data.length == 0){

                    }else{
                        $('#loadEvent').append(data.html);
                    }
                },error: function(data){

                },
            })
        });


    </script>


@endsection
