<form id="formAccountSettings" method="POST" action="{{ isset($user) ? route('admin.user.update') : route('admin.user.create') }}">
        @if(isset($user))
            <input type="hidden" name="id" value="{{ $user->id }}">
        @endif
        <div class="row gy-4 gx-6 mb-6">
            <div class="col-md-6 form-control-validation">
                <label for="firstName" class="form-label">@lang('user.name')</label>
                <input class="form-control" type="text" id="firstName" name="name" value="{{ old('name', $user['name'] ?? '') }}" autofocus />
                <div error-name="name"></div>
            </div>
            <div class="col-md-6 form-control-validation">
                <label for="lastName" class="form-label">@lang('user.surname')</label>
                <input class="form-control" type="text" name="surname" value="{{ old('surname', $user['surname'] ?? '') }}" id="lastName"/>
                <div error-name="surname"></div>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">@lang('user.email')</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user['email'] ?? '') }}" placeholder="john.doe@example.com" />
                <div error-name="email"></div>
            </div>
            <div class="col-md-6">
                <label for="title" class="form-label">@lang('user.user_title')</label>
                <input class="form-control" id="title" name="title" value="{{ old('title', $user['title'] ?? '') }}"/>
            </div>
        </div>
        <div class="row gy-sm-6 gy-2 mb-sm-0 mb-2">
            <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                <label class="form-label" for="newPassword">@lang('user.new_password')</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" type="password" id="password" name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    <span class="input-group-text cursor-pointer"><i
                            class="icon-base ti tabler-eye-off icon-xs"></i></span>
                </div>
                <div error-name="password"></div>
            </div>

            <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                <label class="form-label" for="confirmPassword">@lang('user.confirm_password')</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" type="password" name="password_confirmation" id="confirmPassword"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    <span class="input-group-text cursor-pointer"><i
                            class="icon-base ti tabler-eye-off icon-xs"></i></span>
                </div>
            </div>
        </div>
        <div class="row gy-4 gx-6 mb-6">
            <div class="col-md-6">
              <label for="approver_user" class="form-label">@lang('user.approver_user')</label>
              <select class="form-select" id="approver_user" name="approver_user">
                <option value="">{{ __('words.choose') }}</option>
                @foreach ($approver_users as $approver)
                  <option value="{{ $approver->id }}" 
                    {{ (old('approver_user', $user['approver_user'] ?? '') == $approver->id) ? 'selected' : '' }}>
                    {{ $approver->name }} {{ $approver->surname }} ({{ $approver->title }})
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
