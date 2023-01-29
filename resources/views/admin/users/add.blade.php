@extends('layouts.app')

@section('title', '- Add User')

@section('head')
    <script src="{{ asset("global_assets/js/plugins/forms/selects/select2.min.js") }}"></script>
    <script>
        var addUser = function () {
            var _componentSelect2 = function () {
                if (!$().select2) {
                    console.warn('Warning - select2.min.js is not loaded.');
                    return;
                }

                $('.select').select2({
                    minimumResultsForSearch: Infinity
                });

            };

            return {
                init: function () {
                    _componentSelect2();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function () {
            addUser.init();

        });
    </script>
@endsection

@section('content')

    <div class="page-header mt-3">
        <div class="page-header-content header-elements-inline">
            <div class="page-title py-1 d-flex">
                <h5>
                    <span>@lang('app.Add_User')</span>
                </h5>
            </div>
        </div>
    </div>

    <div class="content ">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ asset('admin/users/add') }}">
                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group ">
                                        <label for="firstname">@lang('app.First_Name') <span class="text-danger">*</span></label>
                                        <input id="firstname" type="text" class="form-control @error('firstname') border-danger @enderror" name="firstname" value="{{ old('firstname') }}" autocomplete="firstname" autofocus>
                                        @error('firstname')
                                        <span class="form-text text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group ">
                                        <label for="lastname">@lang('app.Last_Name') <span class="text-danger">*</span></label>
                                        <input id="lastname" type="text" class="form-control @error('lastname') border-danger @enderror" name="lastname" value="{{ old('lastname') }}" autocomplete="lastname" autofocus>
                                        @error('lastname')
                                        <span class="form-text text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="email" >@lang('app.E-Mail_Address') <span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') border-danger @enderror" name="email" value="{{ old('email') }}"   autocomplete="email">
                                @error('email')
                                    <span class="form-text text-danger">
                                                {{ $message }}
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="mobile" >@lang('app.Mobile') <span class="text-danger">*</span></label>
                                <input id="mobile" type="text" class="form-control @error('mobile') border-danger @enderror" name="email" value="{{ old('email') }}"   autocomplete="email">
                                @error('mobile')
                                <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                @enderror
                            </div>

                            <div class="form-group @if ($errors->has('group_role')) border-danger @endif" >
                                <label>@lang('app.Group') <span class="text-danger">*</span></label>
                                <select data-placeholder="---" name="group_role" class="form-control select">
                                    <option></option>
                                    <option @if(old('group_role') == 'superAdmin') selected @endif value="superAdmin">@lang('app.Super_Admin')</option>
                                    <option @if(old('group_role') == 'admin') selected @endif value="admin">@lang('app.Admin')</option>
                                    <option @if(old('group_role') == 'user') selected @endif value="user">@lang('app.User')</option>
                                </select>
                                @if ($errors->has('group_role'))
                                    <span class="form-text text-danger">{{ $errors->first('group_role') }}</span>
                                @endif
                            </div>



                            <div class="form-group">
                                <label for="password" >@lang('app.Password') <span class="text-danger">*</span></label>
                                <input id="password" type="password" class="form-control @error('password') border-danger @enderror" name="password"   autocomplete="new-password">
                                @error('password')
                                <span class="form-text text-danger">
                                             {{ $message }}
                                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" >@lang('app.Confirm_Password') <span class="text-danger">*</span></label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"   autocomplete="new-password">
                            </div>

                            <div class="form-group  mb-0">
                                <button type="submit" class="btn btn-primary">
                                    @lang('app.Submit')
                                    <i class="icon-paperplane ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection


@section('bodyend')

@endsection
