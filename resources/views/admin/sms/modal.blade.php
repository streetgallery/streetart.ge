@extends('layouts.remote')

@section('title', 'SMS Logs')

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
                <h5><span>@lang('app.SMS_Logs') </span> </h5>
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
                            <th> @lang('app.Mobile')</th>
                            <th> @lang('app.Message')</th>
                            <th> @lang('app.Client')</th>
                            <th> @lang('app.Admin')</th>
                            <th> @lang('app.Created_at')</th>
                            <th> @lang('app.Status')</th>
                            <!--<th class="text-center" > </th>-->
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($items as $each)
                            <tr>
                                <td class="table-isp-first text-center"> {{ $each->id }}</td>
                                <td> {{ $each->mobile }} </td>
                                <td> {{ $each->message }} </td>

                                <td>
                                    @if(isset($each->client))
                                        {{ $each->client->firstName }} {{ $each->client->lastName }}
                                    @endif
                                </td>

                                <td>
                                    @if(isset($each->user))
                                        {{ $each->user->name }} {{ $each->user->lastName }}
                                    @elseif($each->user_id == 0)
                                        System
                                    @endif
                                </td>

                                <td> {{ date('d M Y H:i', strtotime($each->created_at)) }} </td>

                                <td class="text-center" >
                                    @if($each->status == 1)
                                        <span class="text-success-700"><i class="icon-checkmark3"></i>  </span>
                                    @else
                                        <span class="text-danger-700"><i class="icon-cross2"></i> </span>
                                    @endif
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
                    <form method="post" action="{{ asset('sms/delete') }}" id="delete-form" >
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
