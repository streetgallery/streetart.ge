@foreach($projects as $key => $each)
    <li>
        <div class="artup-project">
            <a href="{{ asset('project/'.$each->id ) }}" class="artup-project-img">
                @if(isset($each->images[0]->small))
                    <img src="{{ asset($each->images[0]->small) }}"  alt="">
                @endif
                <div class="artup-project-box">
                    <div class="artup-project-title">
                        @if(App::isLocale('ka'))
                            <h1>{{ $each->name }}</h1>
                        @endif
                        @if(App::isLocale('en'))
                            <h1>{{ $each->name_en }}</h1>
                        @endif
                    </div>
                </div>
            </a>
            <div class="artup-project-detail">
                <span class="artup-project-owner">
                    @if(isset($each->artist))
                        @if(isset($each->artist->images[0]->small))
                            <a href="{{ asset('artist/'. $each->artist->id ) }}" class="artup-project-owner-avatar"><img src="{{ asset($each->artist->images[0]->small) }}"  alt=""></a>
                        @endif
                        <a href="{{ asset('artist/'. $each->artist->id ) }}" class="artup-project-owner-name">

                            @if(App::isLocale('ka'))
                                @if(isset($each->artist->username))
                                    {{ $each->artist->username }}
                                @else
                                    {{ $each->artist->firstname }} {{ $each->artist->lastname }}
                                @endif
                            @endif

                            @if(App::isLocale('en'))
                                @if(isset($each->artist->username_en))
                                    {{ $each->artist->username_en }}
                                @else
                                    {{ $each->artist->firstname_en }} {{ $each->artist->lastname_en }}
                                @endif
                            @endif

                        </a>
                    @endif
                </span>
                <div class="artup-project-stats">
                    <!--<span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0.5 0.5 16 16" class="Appreciations-icon-2NG ProjectCoverNeue-icon-vNS ProjectCoverNeue-appreciateIcon-WrB"><path fill="none" d="M.5.5h16v16H.5z"></path><path d="M.5 7.5h3v8h-3zM7.207 15.207c.193.19.425.29.677.293H12c.256 0 .512-.098.707-.293l2.5-2.5c.19-.19.288-.457.293-.707V8.5c0-.553-.445-1-1-1h-5L11 5s.5-.792.5-1.5v-1c0-.553-.447-1-1-1l-1 2-4 4v6l1.707 1.707z"></path></svg>
                        <span>246</span>
                    </span>
                    -->
                    <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" class="ProjectCoverNeue-icon-vNS ProjectCoverNeue-viewsIcon-2EU"><path d="M8.5 3.5c-5 0-8 5-8 5s3 5 8 5 8-5 8-5-3-5-8-5zm0 7c-1.105 0-2-.896-2-2 0-1.106.895-2 2-2 1.104 0 2 .894 2 2 0 1.104-.896 2-2 2z"></path></svg>
                                                <span>{{ $each->views }}</span>
                                            </span>
                </div>
            </div>
        </div>
    </li>
@endforeach
