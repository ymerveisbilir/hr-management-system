<form id="formAccountSettings" method="POST" action="{{ isset($file_type) ? route('admin.file_type.update') : route('admin.file_type.create') }}">
         @if(isset($file_type))
             <input type="hidden" name="id" value="{{ $file_type->id }}">
         @endif
         <div class="row gy-4 gx-6 mb-6">
             <div class="col-md-6 form-control-validation">
                 <label for="firstName" class="form-label">@lang('file_type.name')</label>
                 <input class="form-control" type="text" id="firstName" name="name" value="{{ old('name', $file_type['name'] ?? '') }}" autofocus />
                 <div error-name="name"></div>
             </div>
             <div class="col-md-6 form-control-validation">
                 <label for="allowed_extensions" class="form-label">@lang('file_type.allowed_extensions')</label>
                 <input class="form-control" type="text" name="allowed_extensions" 
                  value="{{ old('allowed_extensions', isset($file_type['allowed_extensions']) ? implode(',', $file_type['allowed_extensions']) : '') }}" 
                  id="allowed_extensions" placeholder="pdf,docx,svg"/>
                 <div error-name="allowed_extensions"></div>
             </div>
             <div class="col-md-6">
                  <label for="is_active" class="form-label">@lang('file_type.status')</label>
                  <select class="form-control" id="is_active" name="is_active">
                      <option value="">@lang('words.choose')</option>
                      <option value="1" {{ old('is_active', $file_type['is_active'] ?? '') == 1 ? 'selected' : '' }}>Aktif</option>
                      <option value="0" {{ old('is_active', $file_type['is_active'] ?? '') == 0 ? 'selected' : '' }}>Pasif</option>
                  </select>
                  <div error-name="is_active"></div>
              </div>
         </div>
         <div success-msg></div>
         <div class="mt-2">
             <button type="submit" class="btn btn-primary me-3">@lang('words.save')</button>
         </div>
 </form>
 