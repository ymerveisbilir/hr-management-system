<form id="formAccountSettings" method="POST" action="{{ isset($user_permission_type) ? route('admin.user_permission_type.update') : route('admin.user_permission_type.create') }}">
         @if(isset($user_permission_type))
             <input type="hidden" name="id" value="{{ $user_permission_type->id }}">
         @endif
         <div class="row gy-4 gx-6 mb-6">
             <div class="col-md-6 form-control-validation">
                 <label for="firstName" class="form-label">@lang('user_permission_type.name')</label>
                 <input class="form-control" type="text" name="name" value="{{ old('name', $user_permission_type['name'] ?? '') }}" autofocus />
                 <div error-name="name"></div>
             </div>
         </div>
         <div success-msg></div>
         <div class="mt-2">
             <button type="submit" class="btn btn-primary me-3">@lang('words.save')</button>
         </div>
 </form>
 