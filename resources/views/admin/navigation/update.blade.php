@extends('layouts.app')

@section('title', 'Update navigation')

@section('head')
    <script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script  type="text/javascript">
        var select = function() {
            var _componentSelect2 = function() {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }
                $('.select2').select2({
                    minimumResultsForSearch: Infinity
                });
            };

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
                init: function() {
                    _componentSelect2();
                    _componentModalDelete();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            select.init();
        });
    </script>

@endsection

@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5><span>@lang('app.Update_navigation') </span> </h5>
            </div>
        </div>

    </div>

    <div class="content ">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body">
                        <form method="post" id="itemForm" action="{{ asset('admin/navigation/update/'. $item->id) }}" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>@lang('app.Name')</label>
                                <input type="text" class="form-control @if ($errors->has('name')) border-danger @endif" value="{{ $item->name }}" name="name">
                                @if ($errors->has('name'))
                                    <span class="form-text text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Name') <b>@lang('app.Eng')</b></label>
                                <input type="text" class="form-control @if ($errors->has('name_en')) border-danger @endif" value="{{ $item->name_en }}" name="name_en">
                                @if ($errors->has('name'))
                                    <span class="form-text text-danger">{{ $errors->first('name_en') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Link')</label>
                                <input type="text" class="form-control @if ($errors->has('link')) border-danger @endif" value="{{ $item->link }}" name="link">
                                @if ($errors->has('link'))
                                    <span class="form-text text-danger">{{ $errors->first('link') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Sort')</label>
                                <input type="number" class="form-control @if ($errors->has('sort')) border-danger @endif" value="{{ $item->sort }}" name="sort">
                                @if ($errors->has('sort'))
                                <span class="form-text text-danger">{{ $errors->first('sort') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                <label>@lang('app.Navigation')</label>
                                <select name="navigation" id="navigation" class="form-control select2" data-fouc>
                                    <option @if( $item->navigation == "main") selected @endif value="main">@lang('app.Main')</option>
                                    <option @if( $item->navigation == "top") selected @endif value="top">@lang('app.Top')</option>
                                    <option @if( $item->navigation == "bottom") selected @endif value="bottom">@lang('app.Bottom')</option>
                                </select>
                                @if ($errors->has('navigation'))
                                    <span class="form-text text-danger">{{ $errors->first('navigation') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>@lang('app.Parent')</label>
                                <select name="parent_id" id="parent_id" data-placeholder="@lang('app.Select')" class="form-control select2" data-fouc>
                                    <option value="0">---</option>
                                    @foreach($navigation as $each)
                                        @if(App::isLocale('ka'))
                                            <option @if($item->parent_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                        @if(App::isLocale('en'))
                                            <option @if($item->parent_id == $each->id) selected @endif value="{{ $each->id }}">{{ $each->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('parent_id'))
                                    <span class="form-text text-danger">{{ $errors->first('parent_id') }}</span>
                                @endif
                            </div>


                            <div class="text-right">
                                <a class="btn btn-danger" href="#" data-delete="{{ $item->id }}" data-toggle="modal" data-target="#modal_delete"><i class="icon-trash"></i></a>
                                <button type="submit" class="btn btn-primary">@lang('app.Submit') <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
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
