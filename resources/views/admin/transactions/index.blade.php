@extends('layouts.app')

@section('title', 'Transactions')

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
                <h5>
                    <span>@lang('app.Transactions') </span>
                    <span class="font-weight-semibold text-success-700">{{ $sum }} ₾ </span>
                </h5>
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
                                <th>@lang('app.User') </th>
                                <th>@lang('app.Amount')</th>
                                <th>@lang('app.Method')</th>
                                <th>@lang('app.Transaction_ID')</th>
                                <th>@lang('app.Comment')</th>
                                <th>@lang('app.Created_at')</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($items as $each)
                            <tr>
                                <td class="table-isp-first text-center"> {{ $each->id }}</td>

                                <td>
                                    @if(isset($each->client))
                                        {{ $each->client->firstName }} {{ $each->client->lastName }}
                                    @else
                                        {{ $each->client_id }}
                                    @endif
                                </td>
                                <td> {{ $each->amount }} ₾</td>
                                <td> {{ $each->method }} </td>
                                <td> {{ $each->transactionid }} </td>
                                <td> {{ $each->comment }} </td>
                                <td> {{ date('d M Y H:i', strtotime($each->created_at)) }} </td>
                                <!--
                                <td class="text-center table-icons">
                                    <ul class="list-group list-group-horizontal icons-list">
                                        <li class="list-group-item"><a class="text-danger" href="#" data-delete="{{ $each->id }}" data-toggle="modal" data-target="#modal_delete"><i class="icon-trash"></i></a></li>
                                    </ul>
                                </td>
                                -->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="pagination-box">
                    {{ $items->appends(request()->input())->links() }}
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
                    <form method="post" action="{{ asset('transactions/delete') }}" id="delete-form" >
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
