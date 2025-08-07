@extends('admin.layouts.app')
@section('title')
    @lang('account.security')
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.account') }}"><i
                                    class="icon-base ti tabler-settings icon-sm me-1_5"></i>@lang('account.title')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.account_security') }}"><i
                                    class="icon-base ti tabler-lock icon-sm me-1_5"></i>@lang('account.security')</a>
                        </li>
                    </ul>
                </div>
                <div class="card mb-6">
                    <h5 class="card-header">@lang('account.change_password')</h5>
                    <div class="card-body pt-1">
                        <form id="formAccountSettings" method="POST" action="{{ route('admin.account.security_update') }}">
                            <input type="hidden" name="id" value="{{ $auth_user['id'] }}">
                            <div class="row mb-sm-6 mb-2">
                                <div class="col-md-6 form-password-toggle form-control-validation">
                                    <label class="form-label" for="currentPassword">@lang('account.current_password')</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" name="current_password"
                                            id="currentPassword"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="icon-base ti tabler-eye-off icon-xs"></i></span>
                                    </div>
                                </div>
                                <div error-name="current_password"></div>
                            </div>
                            <div class="row gy-sm-6 gy-2 mb-sm-0 mb-2">
                                <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                                    <label class="form-label" for="newPassword">@lang('account.new_password')</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" id="newPassword" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="icon-base ti tabler-eye-off icon-xs"></i></span>
                                    </div>
                                    <div error-name="password"></div>
                                </div>

                                <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                                    <label class="form-label" for="confirmPassword">@lang('account.confirm_password')</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" name="password_confirmation"
                                            id="confirmPassword"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="icon-base ti tabler-eye-off icon-xs"></i></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-body">@lang('account.password_requirements') : </h6>
                            <ul class="ps-4 mb-0">
                                <li class="mb-4">@lang('account.requirement1')</li>
                                <li class="mb-4">@lang('account.requirement2')</li>
                                <li>@lang('account.requirement3')</li>
                            </ul>
                            <div success-msg></div>
                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary me-3">@lang('words.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')
@endsection
