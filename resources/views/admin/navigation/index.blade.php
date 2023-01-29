@extends('layouts.app')

@section('title', '- Navigation')

@section('head')

    <style>
        .list-group-item {
            padding: .5rem 1.25rem;
        }
        .list-group-item:first-child {
            margin-bottom: 20px;
        }
    </style>
    <script type="text/javascript">

        var Modals = function () {

            var _componentModalDelete = function() {
                $('body').on('click', '[data-delete]', function(){
                     var delete_id = $(this).data("delete");
                    $('#modal_delete').on('show.bs.modal', function() {
                        $(this).find('#delete-id').val(delete_id) ;
                    });
                });
                $( "#delete-btn" ).click(function() {
                    $( "#delete-form" ).submit();
                });
            };


            return {
                initComponents: function() {
                    _componentModalDelete();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            Modals.initComponents();
        });

    </script>

@endsection


@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Navigation') </span> </h5>
            </div>

            <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <a href="{{ asset('admin/navigation/add') }}" class="btn bg-teal-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus3"></i></b> @lang('app.Add_Navigation') </a>
                </div>
            </div>
        </div>

     </div>

    <!--
    <div class="content ">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <table class="table table-isp table-hover table-bordered table-xs">
                        <thead>
                            <tr>
                                <th class="table-isp-first text-center" >@lang('app.ID')</th>
                                <th>@lang('app.Name')</th>
                                <th>@lang('app.Name') @lang('app.Eng') </th>
                                <th>@lang('app.Link') </th>
                                <th class="text-center">@lang('app.Navigation')</th>
                                <th class="text-center">@lang('app.Parent')</th>
                                <th class="text-center">@lang('app.Sort')</th>
                                <th>@lang('app.Created_at')</th>
                                <th class="text-center" > </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($items as $each)
                                <tr>
                                    <td class="table-isp-first text-center"> {{ $each->id }}</td>
                                    <td>{{ $each->name }}</td>
                                    <td>{{ $each->name_en }}</td>
                                    <td>
                                        @if(isset($each->link))
                                            <a href="{{ $each->link }}" target="_blank">@lang('app.Link')</a>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $each->navigation }}</td>
                                    <td class="text-center">
                                        @if(isset($each->parentGet->name))
                                            {{ $each->parentGet->name }}
                                        @else

                                        @endif
                                    </td>
                                    <td class="text-center">{{ $each->sort }}</td>
                                    <td> {{ date('d M Y H:i', strtotime($each->created_at)) }} </td>
                                    <td class="text-center table-icons">
                                        <ul class="list-group list-group-horizontal icons-list">
                                            <li class="list-group-item"><a class="text-primary" href="{{ asset('admin/navigation/update/'. $each->id ) }}"><i class="icon-pencil7"></i></a></li>
                                            <li class="list-group-item"><a class="text-danger" href="#" data-delete="{{ $each->id }}" data-toggle="modal" data-target="#modal_delete"><i class="icon-trash"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    -->
    <div class="content ">
        <div class="row">
            <div class="col-xl-4">
                <div class="list-group">
                    <div class="list-group-item font-weight-semibold border-bottom">@lang('app.Main')</div>

                    @if(isset($main) && $main->first()  )
                        @foreach($main as $each)

                            <a href="{{ asset('admin/navigation/update/'. $each->id ) }}" class="list-group-item list-group-item-action">
                                @if(App::isLocale('ka'))<span>{{ $each->name }} </span>@endif
                                @if(App::isLocale('en'))<span>{{ $each->name_en }} </span>@endif
                            </a>
                            @if(isset($each->parent) && $each->parent->first() )
                                @foreach ($each->parent as $subeach)
                                    <a class="list-group-item list-group-item-action" href="{{ asset('admin/navigation/update/'. $subeach->id ) }}">
                                        &nbsp; &nbsp; &nbsp; &nbsp;↳
                                        @if(App::isLocale('ka')){{ $subeach->name }}@endif
                                        @if(App::isLocale('en')){{ $subeach->name_en }}@endif
                                    </a>
                                @endforeach
                            @endif

                        @endforeach
                    @endif

                </div>


            </div>

            <div class="col-xl-4">
                <div class="list-group">
                    <div class="list-group-item font-weight-semibold border-bottom">@lang('app.Top')</div>

                    @if(isset($top) && $top->first()  )
                        @foreach($top as $each)

                            <a href="{{ asset('admin/navigation/update/'. $each->id ) }}" class="list-group-item list-group-item-action">
                                @if(App::isLocale('ka'))<span>{{ $each->name }} </span>@endif
                                @if(App::isLocale('en'))<span>{{ $each->name_en }} </span>@endif
                            </a>
                            @if(isset($each->parent) && $each->parent->first() )
                                @foreach ($each->parent as $subeach)
                                    <a class="list-group-item list-group-item-action" href="{{ asset('admin/navigation/update/'. $subeach->id ) }}">
                                        &nbsp; &nbsp; &nbsp; &nbsp;↳
                                        @if(App::isLocale('ka')){{ $subeach->name }}@endif
                                        @if(App::isLocale('en')){{ $subeach->name_en }}@endif
                                    </a>
                                @endforeach
                            @endif

                        @endforeach
                    @endif

                </div>


            </div>

            <div class="col-xl-4">
                <div class="list-group">
                    <div class="list-group-item font-weight-semibold border-bottom">@lang('app.Bottom')</div>

                    @if(isset($bottom) && $bottom->first()  )
                        @foreach($bottom as $each)

                            <a href="{{ asset('admin/navigation/update/'. $each->id ) }}" class="list-group-item list-group-item-action">
                                @if(App::isLocale('ka'))<span>{{ $each->name }} </span>@endif
                                @if(App::isLocale('en'))<span>{{ $each->name_en }} </span>@endif
                            </a>
                            @if(isset($each->parent) && $each->parent->first() )
                                @foreach ($each->parent as $subeach)
                                    <a class="list-group-item list-group-item-action" href="{{ asset('admin/navigation/update/'. $subeach->id ) }}">
                                        &nbsp; &nbsp; &nbsp; &nbsp;↳
                                        @if(App::isLocale('ka')){{ $subeach->name }}@endif
                                        @if(App::isLocale('en')){{ $subeach->name_en }}@endif
                                    </a>
                                @endforeach
                            @endif

                        @endforeach
                    @endif

                </div>


            </div>
        </div>
    </div>

@endsection


@section('bodyend')

    <!-- Delete Modale -->
    <div id="modal_delete" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('app.Delete')</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    @lang('app.Are_you_sure_delete')
                    <form method="post" action="{{ asset('admin/navigation/delete') }}" id="delete-form" >
                        @csrf
                        <input type="hidden" value="" name="id" id="delete-id"  />
                    </form>
                </div>

                <div class="modal-footer">
                    <a href="#" onclick="" id="delete-btn" class="btn bg-primary">@lang('app.Delete')</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modale -->


@endsection
