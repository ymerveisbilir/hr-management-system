@extends('admin.layouts.app')
@section('title')
    @lang('account.title')
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.account') }}"><i
                                    class="icon-base ti tabler-settings icon-sm me-1_5"></i>@lang('account.title')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.account_security') }}"><i
                                    class="icon-base ti tabler-lock icon-sm me-1_5"></i>@lang('account.security')</a>
                        </li>
                    </ul>
                </div>
                <div class="card mb-6">
                    <!-- Account -->
                    <form id="formAccountSettings" method="POST" action="{{ route('admin.account.update') }}">
                    <div class="card-body pt-4">
                            <div class="row gy-4 gx-6 mb-6">
                                <div class="col-md-6 form-control-validation">
                                    <label for="firstName" class="form-label">@lang('account.name')</label>
                                    <input class="form-control" type="text" id="firstName" name="name"
                                        value="{{ $auth_user['name'] }}" autofocus />
                                </div>
                                <div class="col-md-6 form-control-validation">
                                    <label for="lastName" class="form-label">@lang('account.surname')</label>
                                    <input class="form-control" type="text" name="surname" id="lastName"
                                        value="{{ $auth_user['surname'] }}" />
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">@lang('account.email')</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ $auth_user['email'] }}" placeholder="john.doe@example.com" />
                                </div>
                            </div>
                            <div class="row gy-4 gx-6 mb-6">
                                <div class="col-md-6">
                                    <label for="title" class="form-label">@lang('account.user_title')</label>
                                    <input class="form-control" id="title" name="title"
                                        value="{{ $auth_user['title'] }}"/>
                                </div>
                            </div>
                            <div success-msg></div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-3">@lang('words.save')</button>
                            </div>
                    </div>
                    </form>
                    <!-- /Account -->
                </div>
            </div>
    @endsection
    @section('js')
    @endsection
