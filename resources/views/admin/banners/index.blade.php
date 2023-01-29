@extends('layouts.app')

@section('title', '- Banners')

@section('head')
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
                <h5><span>@lang('app.Banners') </span> </h5>
            </div>

            <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <a href="{{ asset('admin/banners/add') }}" class="btn bg-teal-400 btn-labeled btn-labeled-left rounded-round"><b><i class="icon-plus3"></i></b> @lang('app.Add_Banner') </a>
                </div>
            </div>
        </div>

     </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-12">

                <div class="card">
                    <table class="table table-isp table-hover table-bordered table-xs">
                        <thead>
                        <tr>
                            <th class="table-isp-first text-center" >@lang('app.ID')</th>
                            <th class="text-center">@lang('app.Image')</th>
                            <th>@lang('app.Name')</th>
                            <th>@lang('app.Link')</th>
                            <th>@lang('app.Created_at')</th>
                            <th class="text-center" > </th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($items as $each)
                                <tr>
                                    <td class="table-isp-first text-center"> {{ $each->id }}</td>

                                    <td style="width: 90px" class="text-center">
                                        @if(isset($each->images[0]->small))
                                            <img src="{{ asset($each->images[0]->small) }}" height="90">
                                        @endif
                                    </td>

                                    <td>{{ $each->name }}</td>
                                    <td><a target="_blank" href="{{ $each->link }}">{{ $each->link }}</a></td>

                                    <td> {{ date('d M Y H:i', strtotime($each->created_at)) }} </td>
                                    <td class="text-center table-icons">
                                        <ul class="list-group list-group-horizontal icons-list">
                                            <li class="list-group-item"><a class="text-primary" href="{{ asset('admin/banners/update/'. $each->id ) }}"><i class="icon-pencil7"></i></a></li>
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
                    <form method="post" action="{{ asset('admin/banners/delete') }}" id="delete-form" >
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
