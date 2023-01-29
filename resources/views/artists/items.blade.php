@extends('layouts.site')

@section('content')




    <section class="artists-page">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <ol class="artup-list mt-2" >
                        <li class="mb-1">
                            <a href="/artists" class="home-title new"> @lang('site.ARTISTS') </a>
                        </li>
                    <!--  <li class="">
                            <a href="/projects" class="home-title archive"> @lang('site.ARCHIVE') </a>
                        </li>
                        <li class=" ">
                            <a href="/artists" class="home-title artists"> @lang('site.ARTISTS') </a>
                        </li>
                        <li class=" ">
                            <a href="/events" class="home-title events"> @lang('site.EVENTS') </a>
                        </li>
                        -->
                    </ol>

                     <ol class="artup-list mb-5" id="grid">
                         @foreach($items as $key => $each)
                             <li>
                                 <div class="artup-artist">
                                     <a href="{{ asset('artist/'.$each->id ) }}">
                                         @if(isset($each->images[0]->small))
                                             <img src="{{ asset($each->images[0]->small) }}"  alt="">
                                         @endif
                                     </a>
                                     @if(App::isLocale('ka'))
                                         <h1><a href="{{ asset('artist/'.$each->id ) }}">
                                                     @if(isset($each->username))
                                                         {{ $each->username }}
                                                     @else
                                                         {{ $each->firstname }} {{ $each->lastname }}
                                                     @endif 
                                             </a></h1>
                                         <div class="artist-location">
                                             @if(isset($each->city) || isset($each->city))
                                                 <a href="{{ asset('artist/'.$each->id ) }}">
                                                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="-4808 -20688 14.286 20" class="Profile-locationIcon-2q2"><g><path d="M-4800.857-20688a7.143 7.143 0 0 0-7.143 7.143c0 5.714 7.143 12.857 7.143 12.857s7.143-7.143 7.143-12.857a7.142 7.142 0 0 0-7.143-7.143zm0 10a2.857 2.857 0 1 1 2.857-2.859 2.858 2.858 0 0 1-2.857 2.859z"></path></g></svg>
                                                     @if(isset($each->country))
                                                         {{ $each->country->name  }}
                                                     @endif
                                                     -
                                                     @if(isset($each->city))
                                                         {{ $each->city->name }}
                                                     @endif
                                                 </a>
                                             @endif
                                         </div>
                                     @endif
                                     @if(App::isLocale('en'))
                                         <h1><a href="{{ asset('artist/'.$each->id ) }}">
                                                     @if(isset($each->username_en))
                                                         {{ $each->username_en }}
                                                     @else
                                                         {{ $each->firstname_en }} {{ $each->lastname_en }}
                                                     @endif
                                             </a></h1>
                                         <div class="artist-location">
                                             @if(isset($each->city) || isset($each->city))
                                                 <a href="{{ asset('artist/'.$each->id ) }}">
                                                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="-4808 -20688 14.286 20" class="Profile-locationIcon-2q2"><g><path d="M-4800.857-20688a7.143 7.143 0 0 0-7.143 7.143c0 5.714 7.143 12.857 7.143 12.857s7.143-7.143 7.143-12.857a7.142 7.142 0 0 0-7.143-7.143zm0 10a2.857 2.857 0 1 1 2.857-2.859 2.858 2.858 0 0 1-2.857 2.859z"></path></g></svg>
                                                     @if(isset($each->country))
                                                     {{ $each->country->name_en }}
                                                    @endif
                                                     -
                                                     @if(isset($each->city))
                                                         {{ $each->city->name_en }}
                                                     @endif
                                                 </a>
                                             @endif
                                         </div>
                                     @endif
                                 </div>
                             </li>
                         @endforeach
                     </ol>
                </div>
                <div class="col-12">
                    {{ $items->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection



@section('bodyend')



@endsection
