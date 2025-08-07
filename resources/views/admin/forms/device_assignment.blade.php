<form id="formAccountSettings" method="POST" action="{{ isset($device_assignment) ? route('admin.device_assignment.update') : route('admin.device_assignment.create') }}">
         @if(isset($device_assignment))
             <input type="hidden" name="id" value="{{ $device_assignment->id }}">
         @endif
         <div class="row gy-4 gx-6 mb-6">
             <div class="col-md-6">
                      <label for="device_id" class="form-label">@lang('device_assignment.device_id')</label>
                      <select class="form-select" id="device_id" name="device_id">
                        <option value="">{{ __('words.choose') }}</option>
                        @foreach ($devices as $device)
                        <option value="{{ $device->id }}"
                           {{ (old('device_id', $device_assignment->device_id ?? '') == $device->id) ? 'selected' : '' }}>
                           {{ $device->name }} - {{ $device->type }} ({{ $device->serial_number }})
                         </option>
                        @endforeach
                      </select>
             </div>
             <div class="col-md-6">
               <label for="user_id" class="form-label">@lang('device_assignment.user_id')</label>
               <select class="form-select" id="user_id" name="user_id">
                 <option value="">{{ __('words.choose') }}</option>
                 @foreach ($users as $user)
                 <option value="{{ $user->id }}"
                  {{ (old('user_id', $device_assignment->user_id ?? '') == $user->id) ? 'selected' : '' }}>
                  {{ $user->name }} {{ $user->surname }} ({{ $user->title }})
                </option>
                 @endforeach
               </select>
             </div>
         </div>
         <div class="row gy-4 gx-6 mb-6">
                  <div class="col-md-6 form-control-validation">
                      <label for="note" class="form-label">@lang('device_assignment.note')</label>
                      <input class="form-control" type="text" id="note" name="note" value="{{ old('note', $device_assignment['note'] ?? '') }}"/>
                      <div error-name="note"></div>
                  </div>
         </div>
         <div class="row gy-4 gx-6 mb-6">
                  <div class="col-md-6 form-control-validation">
                  <label for="returned_at" class="form-label">@lang('device_assignment.returned_at')</label>
                  @php
                  $returnedAt = old('returned_at') 
                      ?? (isset($device_assignment) && $device_assignment->returned_at ? $device_assignment->returned_at->format('Y-m-d') : '');
                  @endphp
                  <input class="form-control" type="date" id="returned_at" name="returned_at" value="{{ $returnedAt }}" />
                  <div error-name="returned_at"></div>
              </div>
         </div>
         <div success-msg></div>
         <div class="mt-2">
             <button type="submit" class="btn btn-primary me-3">@lang('words.save')</button>
         </div>
 </form>
 