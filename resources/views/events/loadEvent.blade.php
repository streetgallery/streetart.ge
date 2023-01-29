<div class="backdiv"><a class="backarticle"  onclick="goBack()" href="#"><i class="back"></i>@lang('site.Back')</a></div>

@if(App::isLocale('ka'))
    <h1>{{ $item->name }}</h1>
@endif

@if(App::isLocale('en'))
    <h1>{{ $item->name_en }}</h1>
@endif

@if(isset($item->images[0]->original))
    <div class="article-img">
        <img src="{{ asset($item->images[0]->original) }}">
    </div>
@endif


<div class="event-item mt-3 mb-4">

     
    <div class="event-details">
        <div class="form-row">
            <div class="col-9 col-sm-6">
                <div class="event-item-name">
                    @if(App::isLocale('ka'))
                        <h1 class="text-left"><a href="{{ asset('exhibition/'.$item->id) }}">{{ $item->name }}</a></h1>
                    @endif

                    @if(App::isLocale('en'))
                        <h1 class="text-left"><a href="{{ asset('exhibition/'.$item->id) }}">{{ $item->name_en }}</a></h1>
                    @endif

                    <div class="event-item-loctags">
                        @php($arrayLocation = explode(",", $item->location_id))
                        @foreach($locations as $location)
                            @if(in_array($location->id, $arrayLocation))
                                @if(App::isLocale('ka'))
                                    <a href="{{ asset('locations?id='. $location->id) }}" class="btn btn-location"><i class="fas fa-map-marker-alt"></i> {{ $location->name }} </a>
                                @endif
                                @if(App::isLocale('en'))
                                    <a href="{{ asset('locations?id='. $location->id) }}" class="btn btn-location"><i class="fas fa-map-marker-alt"></i> {{ $location->name_en }} </a>
                                @endif
                            @endif
                        @endforeach

                        @if (!is_null($item->keywords))
                            @foreach(explode(', ', $item->keywords) as $keyword)
                                <a href="{{ asset('events?keyword='. $keyword) }}" class="btn btn-tag2">
                                    <i class="far fa-hashtag"></i>  {{ $keyword }}
                                </a>
                            @endforeach
                        @endif

                            @if(isset($item->facebook))
                                <a class="btn btn-soc" target="_blank" href="{{ $item->facebook }}">
                                    <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"/></svg>
                                </a>
                            @endif

                            @if(isset($item->instagram))
                                <a class="btn btn-soc" target="_blank" href="{{ $item->instagram }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" role="img" class="icon fill-current"><path d="M8 0C5.827 0 5.555.01 4.702.048 3.85.088 3.27.222 2.76.42c-.526.204-.973.478-1.417.923-.445.444-.72.89-.923 1.417-.198.51-.333 1.09-.372 1.942C.008 5.555 0 5.827 0 8s.01 2.445.048 3.298c.04.852.174 1.433.372 1.942.204.526.478.973.923 1.417.444.445.89.72 1.417.923.51.198 1.09.333 1.942.372.853.04 1.125.048 3.298.048s2.445-.01 3.298-.048c.852-.04 1.433-.174 1.942-.372.526-.204.973-.478 1.417-.923.445-.444.72-.89.923-1.417.198-.51.333-1.09.372-1.942.04-.853.048-1.125.048-3.298s-.01-2.445-.048-3.298c-.04-.852-.174-1.433-.372-1.942-.204-.526-.478-.973-.923-1.417-.444-.445-.89-.72-1.417-.923-.51-.198-1.09-.333-1.942-.372C10.445.008 10.173 0 8 0zm0 1.44c2.136 0 2.39.01 3.233.048.78.036 1.203.166 1.485.276.374.145.64.318.92.598.28.28.453.546.598.92.11.282.24.705.276 1.485.038.844.047 1.097.047 3.233s-.01 2.39-.048 3.233c-.036.78-.166 1.203-.276 1.485-.145.374-.318.64-.598.92-.28.28-.546.453-.92.598-.282.11-.705.24-1.485.276-.844.038-1.097.047-3.233.047s-2.39-.01-3.233-.048c-.78-.036-1.203-.166-1.485-.276-.374-.145-.64-.318-.92-.598-.28-.28-.453-.546-.598-.92-.11-.282-.24-.705-.276-1.485C1.45 10.39 1.44 10.136 1.44 8s.01-2.39.048-3.233c.036-.78.166-1.203.276-1.485.145-.374.318-.64.598-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276C5.61 1.45 5.864 1.44 8 1.44zm0 2.452c-2.27 0-4.108 1.84-4.108 4.108 0 2.27 1.84 4.108 4.108 4.108 2.27 0 4.108-1.84 4.108-4.108 0-2.27-1.84-4.108-4.108-4.108zm0 6.775c-1.473 0-2.667-1.194-2.667-2.667 0-1.473 1.194-2.667 2.667-2.667 1.473 0 2.667 1.194 2.667 2.667 0 1.473-1.194 2.667-2.667 2.667zm5.23-6.937c0 .53-.43.96-.96.96s-.96-.43-.96-.96.43-.96.96-.96.96.43.96.96z"></path></svg>
                                </a>
                            @endif

                    </div>
                </div>
            </div>
            <div class="col-3 col-sm-2">
                <div class="event-item-date">
                    @if(isset($item->event_date))
                        <div class="event-date">
                            <span class="day">{{ $item->event_date->translatedFormat('d') }}</span>
                            <span class="month">{{ $item->event_date->translatedFormat('M') }}</span>
                            <span class="year">{{ $item->event_date->translatedFormat('Y') }}</span>
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-4 d-none d-sm-block">
                @if(isset($item->artist))
                    <div class="event-item-author">
                        <div class="author-event">
                            <div class="user-avatar">
                                @if(isset($item->artist->images[0]->small))
                                    <img src="{{ asset($item->artist->images[0]->small) }}" height="90">
                                @endif
                            </div>
                            @if(App::isLocale('ka'))
                                @if(isset($item->artist->username))
                                    <h1>{{ $item->artist->username }}</h1>
                                @else
                                    <h1>{{ $item->artist->firstname }} {{ $item->artist->lastname }}</h1>
                                @endif
                            @endif

                            @if(App::isLocale('en'))
                                @if(isset($item->artist->username_en))
                                    <h1>{{ $item->artist->username_en }}</h1>
                                @else
                                    <h1>{{ $item->artist->firstname_en }} {{ $item->artist->lastname_en }}</h1>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>



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
            <a class="facebook" target="_blank" href="{{ asset('exhibition/'. $item->id ) }}" onclick="share();">
                <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z"></path></svg>
            </a>
        </li>
    </ul>
</div>