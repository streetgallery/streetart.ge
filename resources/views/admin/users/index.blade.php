@extends('layouts.app')

@section('title', 'Users')

@section('head')

    <script type="text/javascript">

        var Modals = function () {

            var _componentModalDelete = function() {
                $('body').on('click', '[data-delete]', function(){
                    var delete_id = $(this).data("delete");
                    var itemname = $(this).data("itemname");
                    $('#modal_delete').on('show.bs.modal', function() {
                        $(this).find('#delete-id').val(delete_id) ;
                        $(this).find('.itemname').text(itemname) ;
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
                <h5>
                    <span class=" ">@lang('Users') </span> <small class="text-muted">{{ $count  }} @lang('app.items')</small>
                </h5>

            </div>

            <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <a href="{{ asset('admin/users/new') }}" class="btn bg-teal-400"><i class="icon-plus3 mr-2"></i> @lang('app.Add_User') </a>
                </div>
            </div>

        </div>

    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-12">

                <!-- Single line -->
                <div class="card1">

                    <!-- Table -->
                    <table class="table text-nowrap table-hover table-bordered table-xs table-isp">
                        <thead>
                        <tr>
                            <th class="table-isp-first text-center">@lang('app.ID')</th>
                            <th style="width:100px;" class="text-center">@lang('app.Image')</th>
                            <th>@lang('app.First_Name') @lang('app.Last_Name')</th>
                            <th>@lang('app.Email')</th>
                            <th>@lang('app.Mobile')</th>
                            <th>@lang('app.Group')</th>
                            <th class="text-center" > </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($items as $each)
                            <tr>
                                <td class="table-isp-first text-center" >{{ $each->id }}</td>
                                <td class="text-center">
                                    @if(isset($each->images[0]->small))
                                        <img src="{{ asset($each->images[0]->small) }}" height="90">
                                    @endif
                                </td>
                                <td> {{ $each->firstname }} {{ $each->lastname }} </td>
                                <td> {{ $each->email }} </td>
                                <td> {{ $each->mobile }} </td>
                                <td>
                                    @if($each->group_role == "superAdmin")
                                        @lang('app.Super_Admin')
                                    @endif

                                    @if($each->group_role == "admin")
                                        @lang('app.admin')
                                    @endif

                                    @if($each->group_role == "user")
                                        @lang('app.User')
                                    @endif


                                </td>
                                <td class="text-center table-icons">
                                    <ul class="list-group list-group-horizontal icons-list">
                                        <li class="list-group-item"><a class="text-primary" href="{{ asset('admin/users/update/'. $each->id ) }}"><i class="icon-pencil7"></i></a></li>
                                        <li class="list-group-item"><a class="text-danger" href="#" data-itemname="{{ $each->name }}" data-delete="{{ $each->id }}" data-toggle="modal" data-target="#modal_delete"><i class="icon-trash"></i></a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /table -->

                </div>
                <!-- /single line -->

                <div class="pagination-box">
                    {{ $items->appends(request()->input())->links() }}
                </div>

            </div>
        </div>
    </div>

@endsection


@section('bodyend')

    <div id="modal_delete" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-trash mr-1"></i>@lang('Delete')</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    @lang('app.Are_you_sure_delete') (<b class="itemname"></b>)?
                    <form method="post" action="{{ asset('admin/users/delete') }}" id="delete-form" >
                        @csrf
                        <input type="hidden" value="" name="id" id="delete-id"  />
                    </form>
                </div>

                <div class="modal-footer">
                    <a href="#" onclick="" id="delete-btn" class="btn bg-danger-600">@lang('app.Delete')</a>
                </div>
            </div>
        </div>
    </div>

@endsection
