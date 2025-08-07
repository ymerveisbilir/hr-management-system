<form id="formAccountSettings" method="POST" action="{{ isset($user_permission) ? route('admin.user_permission.update') : route('admin.user_permission.create') }}">
         @if(isset($user_permission))
             <input type="hidden" name="id" value="{{ $user_permission->id }}">
         @endif
         <div class="row gy-4 gx-6 mb-6">
             <div class="col-md-6 form-control-validation">
                 <label for="start_date" class="form-label">@lang('user_permission.start_date')</label>
                 <input class="form-control" type="date" id="start_date" name="start_date" value="{{ old('start_date', isset($user_permission) ? \Carbon\Carbon::parse($user_permission->start_date)->format('Y-m-d') : '') }}" />
                 <div error-name="start_date"></div>
             </div>
     
             <div class="col-md-6 form-control-validation">
                 <label for="end_date" class="form-label">@lang('user_permission.end_date')</label>
                 <input class="form-control" type="date" id="end_date" name="end_date" value="{{ old('end_date', isset($user_permission) ? \Carbon\Carbon::parse($user_permission->end_date)->format('Y-m-d') : '') }}" />
                 <div error-name="end_date"></div>
             </div>
             <div class="col-md-6 form-control-validation">
                  <label for="description" class="form-label">@lang('user_permission.description')</label>
                  <input class="form-control" type="text" name="description" value="{{ old('description', $user_permission['description'] ?? '') }}" autofocus />
                  <div error-name="description"></div>
              </div>
         </div>
         <div class="row gy-4 gx-6 mb-6">
                  <div class="col-md-6">
                    <label for="permission_type_id" class="form-label">@lang('user_permission.permission_type_id')</label>
                    <select class="form-select" id="permission_type_id" name="permission_type_id">
                      <option value="">{{ __('words.choose') }}</option>
                      @foreach ($user_permission_types as $type)
                        <option value="{{ $type->id }}" 
                          {{ (old('permission_type_id', $user_permission['permission_type_id'] ?? '') == $type->id) ? 'selected' : '' }}>
                          {{ $type->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
         </div>
         <div success-msg></div>
         <div class="mt-2">
             <button type="submit" class="btn btn-primary me-3">@lang('words.save')</button>
         </div>
     </form>
     