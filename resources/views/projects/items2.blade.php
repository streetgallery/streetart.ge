@extends('layouts.site')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')

    <section class="store-page">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <form id="filter_project" action="/projects">
                        <ol class="artup-list mt-1" >
                            <li class="">
                                <a href="/projects" class="home-title new"> @lang('site.ARCHIVE') </a>
                            </li>
                            <li class="">

                                <div class="form-group mb-0">
                                     <select name="artist_id" id="artist_id" class="form-control select2" data-placeholder="@lang('app.Artists')">
                                        <option value="">@lang('app.Artists')</option>

                                        @foreach($artists as $each)
                                            @if(App::isLocale('ka'))
                                                <option @if($request->artist_id == $each->id) selected @endif value="{{ $each->id }}">
                                                    @if(isset($each->username))
                                                        {{ $each->username }}
                                                    @else
                                                        {{ $each->firstname }} {{ $each->lastname }}
                                                    @endif
                                                </option>
                                            @endif
                                            @if(App::isLocale('en'))
                                                <option @if($request->artist_id == $each->id) selected @endif value="{{ $each->id }}">
                                                    @if(isset($each->username_en))
                                                        {{ $each->username_en }}
                                                    @else
                                                        {{ $each->firstname_en }} {{ $each->lastname_en }}
                                                    @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="">
                                <div class="form-group mb-0">
                                     <select name="location_id" id="location_id" class="form-control select2" data-placeholder="@lang('app.Locations')">
                                        <option value=""></option>
                                         @foreach($locations as $each)
                                             @if(App::isLocale('ka'))
                                                 <option @if($request->location_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                             @endif
                                             @if(App::isLocale('en'))
                                                 <option @if($request->location_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                             @endif
                                         @endforeach
                                    </select>
                                </div>

                            </li>
                            <li class="">
                                <div class="form-group mb-0">
                                     <select name="category_id" id="category_id" class="form-control select2" data-placeholder="@lang('app.Categories')">
                                        <option value="">/option>
                                         @foreach($categories as $each)
                                             @if(App::isLocale('ka'))
                                                 <option @if($request->category_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                             @endif
                                             @if(App::isLocale('en'))
                                                 <option @if($request->category_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                             @endif
                                         @endforeach
                                    </select>
                                </div>

                            </li>
                        </ol>
                    </form>

                    @if($request->input('category_id') != '' || $request->input('artist_id') != '' || $request->input('location_id') != '')
                        <div class="mb-4">

                            @if($request->input('artist_id'))
                                @foreach($artists as $each)
                                    @if($request->artist_id == $each->id)
                                        <a href="{{ route('projects', array_merge(request()->all(),['artist_id'=> ''])) }}" class="btn tag-search">
                                            @if(App::isLocale('ka'))
                                                @if(isset($each->username))
                                                    {{ $each->username }}
                                                @else
                                                    {{ $each->firstname }} {{ $each->lastname }}
                                                @endif
                                            @endif
                                            @if(App::isLocale('en'))
                                                @if(isset($each->username_en))
                                                    {{ $each->username_en }}
                                                @else
                                                    {{ $each->firstname_en }} {{ $each->lastname_en }}
                                                @endif
                                            @endif

                                            <span aria-hidden="true">×</span>

                                        </a>
                                    @endif

                                @endforeach
                            @endif

                            @if($request->input('category_id'))
                                @foreach($categories as $each)
                                    @if($request->category_id == $each->id)
                                        <a href="{{ route('projects', array_merge(request()->all(),['category_id'=> ''])) }}" class="btn tag-search">
                                            @if(App::isLocale('ka'))
                                                {{ $each->name }}
                                            @endif
                                            @if(App::isLocale('en'))
                                                    {{ $each->name_en }}
                                            @endif
                                            <span aria-hidden="true">×</span>
                                        </a>
                                    @endif

                                @endforeach
                            @endif
                            @if($request->input('location_id'))
                                @foreach($locations as $each)
                                    @if($request->location_id == $each->id)
                                        <a href="{{ route('projects', array_merge(request()->all(),['location_id'=> ''])) }}" class="btn tag-search">
                                            @if(App::isLocale('ka'))
                                                {{ $each->name }}
                                            @endif
                                            @if(App::isLocale('en'))
                                                    {{ $each->name_en }}
                                            @endif
                                            <span aria-hidden="true">×</span>
                                        </a>
                                    @endif

                                @endforeach
                            @endif

                        </div>
                    @endif


                    <ol class="artup-list" id="grid">

                        @foreach($projects as $key => $each)
                            <li>

                                <div class="artup-project">
                                    <a href="{{ asset('project/'.$each->id ) }}" class="artup-project-img">
                                        @if(isset($each->images[0]->medium))
                                            <img src="{{ asset($each->images[0]->medium) }}"  alt="">
                                        @endif
                                    </a>
                                    <a href="{{ asset('project/'.$each->id ) }}" class="artup-project-box">
                                        <div class="artup-project-title">
                                            <h1>
                                                @if(App::isLocale('ka'))
                                                    {!! $each->name !!}
                                                @endif
                                                @if(App::isLocale('en'))
                                                    {!! $each->name_en !!}
                                                @endif
                                            </h1>
                                        </div>
                                    </a>
                                    <div class="artup-project-detail">
                                        @if(isset($each->artist))
                                            <span class="artup-project-owner">
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
                                        </span>
                                        @endif

                                        <div class="artup-project-stats">
                                            <a href="{{ asset('project/'.$each->id ) }}">
                                                <svg class="mx-auto" id="Layer_1" enable-background="new 0 0 512 512"
                                                     height="64" viewBox="0 0 512 512" width="64"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path d="m407.579 87.677c-31.073-53.624-86.265-86.385-147.64-87.637-2.62-.054-5.257-.054-7.878 0-61.374 1.252-116.566 34.013-147.64 87.637-31.762 54.812-32.631 120.652-2.325 176.123l126.963 232.387c.057.103.114.206.173.308 5.586 9.709 15.593 15.505 26.77 15.505 11.176 0 21.183-5.797 26.768-15.505.059-.102.116-.205.173-.308l126.963-232.387c30.304-55.471 29.435-121.311-2.327-176.123zm-151.579 144.323c-39.701 0-72-32.299-72-72s32.299-72 72-72 72 32.299 72 72-32.298 72-72 72z"></path>
                                                    </g>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        @endforeach

                    </ol>

                </div>

                <div class="col-12">
                    <div class="mb-5">
                        {{ $projects->appends(request()->input())->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('bodyend')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script  type="text/javascript">
        /// $('.select2').select2();
        $('.select2').select2({
         //   allowClear: true,
            minimumResultsForSearch: Infinity

        });

        $('#artist_id').change(function(){
            $('#filter_project').submit();
        });


        $('.select2').on('select2:select', function (e) {
            $('#filter_project').submit();

        });

    </script>

    <script type="text/javascript">
        /*
        $.getJSON( "{{ route('projectsJson', array_merge(request()->all())) }}", function( data ) {
            var lang = $('html').attr('lang');
            $.each(data, function (i, value) {

                if(lang == 'ka'){
                    if(typeof(value.artist.username) != "undefined" && value.artist.username !== null) {
                        artist_name = value.artist.username;
                    } else {
                        artist_name = value.artist.firstname  + ' ' + value.artist.lastname;
                    }
                } else {

                    if(typeof(value.artist.username_en) != "undefined" && value.artist.username_en !== null) {
                        artist_name = value.artist.username_en;
                    } else {
                        artist_name = value.artist.firstname_en  + ' ' + value.artist.lastname_en;
                    }
                }


                if(typeof(value.images[0]) != "undefined" && value.images[0] !== null) {
                    project_image = '<img src="' + value.images[0].small + '"  alt="">';
                } else {
                    project_image = '';
                }

                if(typeof(value.artist.images[0]) != "undefined" && value.artist.images[0] !== null) {
                    user_avatar = '<img src="' + value.artist.images[0].small + '"  alt="">';
                } else {
                    user_avatar = '';
                }

                @if(App::isLocale('ka'))
                if(typeof(value.name) != "undefined" && value.name !== null) {
                    name = value.name;
                } else {
                    name = '';
                }
                @endif

                        @if(App::isLocale('en'))
                if(typeof(value.name_en) != "undefined" && value.name_en !== null) {
                    name_en = value.name_en;
                } else {
                    name_en = '';
                }
                @endif


                var list = '' +
                    '<li class="hide">\n' +
                    '        <div class="artup-project"> \n' +
                    '            <a href="/project/' + value.id + '" class="artup-project-img">\n' +
                    '                   ' + project_image + ' \n' +
                    '            </a>' +
                    '            <a href="/project/' + value.id + '" class="artup-project-box">\n' +
                    '                    <div class="artup-project-title">\n' +
                    '                           @if(App::isLocale('ka')) <h1>' + name + '</h1> @endif @if(App::isLocale('en')) <h1>' + name_en + '</h1> @endif \n' +
                    '                    </div>\n' +
                    '            </a>\n' +
                    '            <div class="artup-project-detail">' +
                    '               <span class="artup-project-owner">' +
                    '                   <a href="/artist/' + value.artist.id + '" class="artup-project-owner-avatar">'+ user_avatar +'</a>' +
                    '                   <a href="/artist/' + value.artist.id + '" class="artup-project-owner-name">\n' +
                    '                   ' + artist_name + ' ' +
                    '                   </a>\n' +
                    '               </span> \n' +
                    '               <div class="artup-project-stats"> \n' +
                    '                   <a href="/locations?id=' + value.id + '"> \n' +
                    '                       <svg class="mx-auto" id="Layer_1" enable-background="new 0 0 512 512" height="64" viewBox="0 0 512 512" width="64" xmlns="http://www.w3.org/2000/svg"><g><path d="m407.579 87.677c-31.073-53.624-86.265-86.385-147.64-87.637-2.62-.054-5.257-.054-7.878 0-61.374 1.252-116.566 34.013-147.64 87.637-31.762 54.812-32.631 120.652-2.325 176.123l126.963 232.387c.057.103.114.206.173.308 5.586 9.709 15.593 15.505 26.77 15.505 11.176 0 21.183-5.797 26.768-15.505.059-.102.116-.205.173-.308l126.963-232.387c30.304-55.471 29.435-121.311-2.327-176.123zm-151.579 144.323c-39.701 0-72-32.299-72-72s32.299-72 72-72 72 32.299 72 72-32.298 72-72 72z"/></g></svg>\n' +
                    '                   </a>\n' +
                    '               </div>\n' +
                    '            </div> \n' +
                    '        </div> \n' +
                    '    </li>'
                $('#grid').append(list);
            });


            function loadMore(){

                $("#grid .hide").slice(0,16).removeClass("hide");

            }

            loadMore();

            function loadMore2(){
                setTimeout(function(load_item){
                    var width = $(window).width();


                    $("#grid .hide").slice(0,4).removeClass("hide");


                }, 300);
            }



            window.onscroll = function(ev) {
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight-570) {
                    loadMore2();
                }
            };

        });
        */
    </script>


@endsection