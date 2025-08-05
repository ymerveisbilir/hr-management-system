@extends('admin.layouts.auth')
@section('title')
    @lang('admin_login.title')
@endsection
@section("content")
<!-- Login -->
<div class="card">
    <div class="card-body">

<!-- Logo -->
<div class="app-brand justify-content-center mb-6">
         <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img src="/hr_logo.svg" style="width: 250px;height: 250px;border-radius: 50%;"/>
                </span>
            </span>
        </a>
     </div>
     <!-- /Logo -->
     <form class="mb-4" action="{{route('admin.login.post')}}" method="post">
         <div class="mb-6 form-control-validation">
             <label for="email" class="form-label">@lang('admin_login.email')</label>
             <input type="text" class="form-control" id="email" name="email"
                 placeholder="@lang('admin_login.email')" autofocus />
                 <div error-name="email"></div>
         </div>
         <div class="mb-6 form-password-toggle form-control-validation">
             <label class="form-label" for="password">@lang('admin_login.password')</label>
             <div class="input-group input-group-merge">
                 <input type="password" id="password" class="form-control" name="password"
                     placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                     aria-describedby="password" />
                 <span class="input-group-text cursor-pointer"><i class="icon-base ti tabler-eye-off"></i></span>
             </div>
         </div>
         <div class="my-8">
             <div class="d-flex justify-content-between">
                 <div class="form-check mb-0 ms-2">
                     <input class="form-check-input" type="checkbox" id="remember-me" name="remember_me" value="1"/>
                     <label class="form-check-label" for="remember-me"> @lang('admin_login.remember_me') </label>
                 </div>
             </div>
         </div>
         <div class="mb-6">
             <button class="btn btn-primary d-grid w-100" type="submit">@lang('admin_login.login')</button>
         </div>
     </form>
     </div>
     </div>
@endsection