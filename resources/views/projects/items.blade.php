@extends('layouts.site')

@section('content')

    <section class="sub-main-menu mt-3 pb-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!--
                    <h1 class="h-store"><span>@lang('site.Artup Projects')</span></h1>
                    -->
                    <div class="navbar-nav-scroll">
                        <ul class="nav nav-menu flex-row">
                            <li><a class="@if(($request->category_id == "" || $request->category_id == 0) && $request->search == "") active @endif" title="All" href="{{ route('projects', array_merge(request()->all(),['category_id'=> '', 'search'=> ''])) }}">@lang("site.All")</a></li>
                            @foreach($categories as $each)
                                <li>
                                    <a class="@if($request->category_id == $each->id) active @endif " title="{{ $each->name }}" href="{{ route('projects', array_merge(request()->all(),['category_id'=> $each->id, 'search'=> ''])) }}">
                                        @if(App::isLocale('ka'))
                                            <span>{{$each->name}}</span>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <span>{{$each->name_en}}</span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="store-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                     <ol class="artup-list" id="grid">

                         @foreach($projects as $key => $each)
                             <li>
                                 <div class="artup-project">
                                     <a href="{{ asset('project/'.$each->id ) }}" class="artup-project-img">
                                         @if(isset($each->images[0]->medium))
                                             <img src="{{ asset($each->images[0]->medium) }}"  alt="">
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
                                             @if(isset($each->location))
                                                 <a href="{{ asset('project/'.$each->id ) }}">
                                                     @if(App::isLocale('ka'))
                                                         {{ $each->location->name }}
                                                     @endif
                                                     @if(App::isLocale('en'))
                                                         {{ $each->location->name_en }}
                                                     @endif
                                                 </a>
                                                 <a href="{{ asset('project/'.$each->id ) }}">
                                                     <svg class="mx-auto" id="Layer_1" enable-background="new 0 0 512 512" height="64" viewBox="0 0 512 512" width="64" xmlns="http://www.w3.org/2000/svg"> <g> <path d="m407.579 87.677c-31.073-53.624-86.265-86.385-147.64-87.637-2.62-.054-5.257-.054-7.878 0-61.374 1.252-116.566 34.013-147.64 87.637-31.762 54.812-32.631 120.652-2.325 176.123l126.963 232.387c.057.103.114.206.173.308 5.586 9.709 15.593 15.505 26.77 15.505 11.176 0 21.183-5.797 26.768-15.505.059-.102.116-.205.173-.308l126.963-232.387c30.304-55.471 29.435-121.311-2.327-176.123zm-151.579 144.323c-39.701 0-72-32.299-72-72s32.299-72 72-72 72 32.299 72 72-32.298 72-72 72z"></path> </g> </svg>
                                                 </a>
                                             @endif
                                         </div>
                                     </div>
                                 </div>
                             </li>
                         @endforeach

                     </ol>
                </div>
                <div class="col-12">
                    <nav class="page-nav pb-5">
                        {{ $projects->appends(request()->input())->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection
 
@section('bodyend')

@endsection
