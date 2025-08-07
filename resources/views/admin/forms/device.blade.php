<form id="formAccountSettings" method="POST" action="{{ isset($device) ? route('admin.device.update') : route('admin.device.create') }}">
         @if(isset($device))
             <input type="hidden" name="id" value="{{ $device->id }}">
         @endif
         <div class="row gy-4 gx-6 mb-6">
             <div class="col-md-6 form-control-validation">
                 <label for="firstName" class="form-label">@lang('device.name')</label>
                 <input class="form-control" type="text" id="firstName" name="name" value="{{ old('name', $device['name'] ?? '') }}" autofocus />
                 <div error-name="name"></div>
             </div>
             <div class="col-md-6 form-control-validation">
                 <label for="type" class="form-label">@lang('device.type')</label>
                 <input class="form-control" type="text" name="type" value="{{ old('type', $device['type'] ?? '') }}" id="type"/>
                 <div error-name="type"></div>
             </div>
             <div class="col-md-6">
                 <label for="serial_number" class="form-label">@lang('device.serial_number')</label>
                 <input class="form-control" type="text" id="serial_number" name="serial_number" value="{{ old('serial_number', $device['serial_number'] ?? '') }}"/>
                 <div error-name="serial_number"></div>
             </div>
             <div class="col-md-6">
                 <label for="description" class="form-label">@lang('device.description')</label>
                 <input class="form-control" id="description" name="description" value="{{ old('description', $device['description'] ?? '') }}"/>
             </div>
         </div>
         <div success-msg></div>
         <div class="mt-2">
             <button type="submit" class="btn btn-primary me-3">@lang('words.save')</button>
         </div>
 </form>
 