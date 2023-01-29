@extends('layouts.site')

@section('head')

@endsection

@section('title', '- ბლოგი')
@section('title_en', '- Blog')
@section('body_class', 'head-no-border')

@section('content')

     


    <section class="blog-feed">
        <div class="container">
            <div class="row" id="grid">
                @foreach($items as $key => $each)

                    @if($key == 0)

                        <div class="col-md-6 col-xl-8">
                            <a href="{{ asset('article/'.$each->id ) }}" class="blog-artup bigblog">
                                @if(isset($each->images[0]->medium))
                                    <img src="{{ asset($each->images[0]->medium) }}" class="blog-artup-img" alt="">
                                @endif
                                <div class="blog-artup-desc">
                                    <div class="blog-artup-data">{{ $each->created_at->translatedFormat('d M Y') }}.</div>
                                    @if(App::isLocale('ka'))
                                        <div class="blog-artup-text">{{ $each->name }}</div>
                                    @endif

                                    @if(App::isLocale('en'))
                                        <div class="blog-artup-text">{{ $each->name_en }}</div>
                                    @endif

                                </div>
                            </a>
                        </div>

                    @elseif($key == 1 || $key == 2)

                        @if($key == 1 )
                            <div class="col-md-6 col-xl-4">
                        @endif
                                <a href="{{ asset('article/'.$each->id ) }}" class="blog-artup rightblog">
                                    @if(isset($each->images[0]->medium))
                                        <img src="{{ asset($each->images[0]->medium) }}" class="blog-artup-img" alt="">
                                    @endif
                                    <div class="blog-artup-desc">
                                        <div class="blog-artup-data">{{ $each->created_at->translatedFormat('d M Y') }}.</div>
                                        @if(App::isLocale('ka'))
                                            <div class="blog-artup-text">{{ $each->name }}</div>
                                        @endif

                                        @if(App::isLocale('en'))
                                            <div class="blog-artup-text">{{ $each->name_en }}</div>
                                        @endif
                                    </div>
                                </a>


                        @if($items->count() == 2 && $key == 1 )
                            </div>
                        @elseif($items->count() > 2 && $key == 2)
                            </div>
                        @endif


            @else
                <div class="col-md-6 col-xl-4">
                    <a href="{{ asset('article/'.$each->id ) }}" class="blog-artup rightblog">
                        @if(isset($each->images[0]->medium))
                            <img src="{{ asset($each->images[0]->medium) }}" class="blog-artup-img" alt="">
                        @endif
                        <div class="blog-artup-desc">
                            <div class="blog-artup-data">{{ $each->created_at->translatedFormat('d M Y') }}.</div>
                            @if(App::isLocale('ka'))
                                <div class="blog-artup-text">{{ $each->name }}</div>
                            @endif

                            @if(App::isLocale('en'))
                                <div class="blog-artup-text">{{ $each->name_en }}</div>
                            @endif
                        </div>
                    </a>
                </div>
            @endif



            @endforeach

        </div>

            <div class="row">
                <div class="col-12">
                    <nav class="page-nav">
                        {{ $items->appends(request()->input())->links() }}
                    </nav>
                </div>
            </div>

        </div>
    </section>


@endsection



@section('bodyend')
    <script type="text/javascript">
      /*
        var pageNumber = 1;

        $(document).ready(function() {
            $.ajax({
                type : 'GET',

                url: "{{ asset('') }}api/blog?&page=" +pageNumber +"&search={{ $request->search }}",
                success : function(data){
                    pageNumber +=1;
                    if(data.length == 0){
                    }else{
                        $('#grid').append(data.html);
                    }
                },error: function(data){

                },
            })
        });

        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                $.ajax({
                    type : 'GET',
                    url: "{{ asset('') }}api/blog?&page=" +pageNumber +"&search={{ $request->search }}",
                    success : function(data){
                        pageNumber +=1;
                        if(data.length == 0){
                        }else{
                            $('#grid').append(data.html);
                        }
                    },error: function(data){

                    },
                })
            }
        });

        function loadMoreData(){
            $.ajax({
                type : 'GET',
                url: "{{ asset('') }}api/blog?&page=" +pageNumber +"&search={{ $request->search }}",
                success : function(data){
                    pageNumber +=1;
                    if(data.length == 0){
                        // :( no more articles
                    }else{
                        $('#grid').append(data.html);
                    }
                },error: function(data){

                },
            })
        }

        */
    </script>


@endsection
