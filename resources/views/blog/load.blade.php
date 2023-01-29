@foreach($articles as $key => $each)

    @if($key == 0)

        <div class="col-xl-8">
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
            <div class="col-xl-4">
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


                @if($articles->count() == 2 && $key == 1 )
            </div>
            @elseif($articles->count() > 2 && $key == 2)
            </div>
        @endif


    @elseif($key > 2 && $key < 7)

        <div class="col-xl-3">
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

    @else

        <div class="col-xl-4">
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
