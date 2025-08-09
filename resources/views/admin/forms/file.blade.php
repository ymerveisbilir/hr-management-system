<form id="formAccountSettings" method="POST"
    action="{{ isset($file) ? route('admin.file.update') : route('admin.file.create') }}">
    @if (isset($file))
        <input type="hidden" name="id" value="{{ $file->id }}">
    @endif
    <div class="mb-3">
        <label for="title" class="form-label">@lang('file.title')</label>
        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $file->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="upload_file" class="form-label">@lang('file.upload_file')</label>
        <input type="file" id="upload_file" name="upload_file"
            class="form-control @error('upload_file') is-invalid @enderror" {{ isset($file) ? '' : 'required' }}
            accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.svg">
        @error('upload_file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if (isset($file))
            <small class="form-text text-muted mt-1">
                @lang('file.current_file'): <a href="{{ asset('storage/' . $file->file_path) }}"
                    target="_blank">{{ $file->original_name }}</a>
            </small>
        @endif
    </div>

    <div class="mb-3">
        <label for="file_type_id" class="form-label">@lang('file.file_type')</label>
        <select id="file_type_id" name="file_type_id" class="form-select @error('file_type_id') is-invalid @enderror"
            required>
            <option value="">@lang('words.choose')</option>
            @foreach ($file_types as $type)
                <option value="{{ $type->id }}"
                    {{ old('file_type_id', $file->file_type_id ?? '') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}</option>
            @endforeach
        </select>
        @error('file_type_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div error-name="upload_file"></div>
    </div>

    <div class="mb-3">
         <label for="user_id" class="form-label">@lang('file.assigned_users')</label>
         <select id="user_id" name="user_id[]" class="form-select select2 @error('user_id') is-invalid @enderror" multiple required>
             @php
                 $selectedUsers = old('user_id', $assignedUsers ?? []);
             @endphp
             @foreach ($users as $user)
                 <option value="{{ $user->id }}" @if(in_array($user->id, $selectedUsers)) selected @endif>
                     {{ $user->name }}
                 </option>
             @endforeach
         </select>
         @error('user_id')
             <div class="invalid-feedback">{{ $message }}</div>
         @enderror
     </div>     
    <div success-msg></div>
    <div class="mt-2">
        <button type="submit" class="btn btn-primary me-3">@lang('words.save')</button>
    </div>
</form>
