@extends('admin.layouts.app')
@php
    use App\Http\Helpers\GlobalVariables;
@endphp
@section('title')
    @lang('user_permission.title')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (isset($new) || isset($user_permission))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                @include('admin.forms.user_permission')
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('user_permission.title') }}</h3>
                        <a class="btn btn-success text-white waves-effect waves-light" href="{{ route('admin.user_permission.new') }}">
                            <i class="icon-base ti tabler-plus ms-2 icon-14px"></i>
                            <small class="align-middle">{{ __('words.new_add') }}</small>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <form action="{{ route('admin.user_permission.index') }}" method="GET" class="d-flex" no-auto>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control me-2"
                                    placeholder="@lang('words.search')"
                                    value="{{ old('search', $search) }}"
                                />
                                <button type="submit" class="btn btn-primary">@lang('words.search')</button>
                                @if(!empty($search))
                                              <a href="{{ route('admin.user_permission.index') }}" class="btn btn-secondary">
                                              @lang('words.clear')
                                              </a>
                                 @endif
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user_permission.start_date') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user_permission.end_date') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user_permission.description') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user_permission.status') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user_permission.created_at') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($user_permissions as $user_permission)
                                    <tr class="hover:bg-gray-100">
                                            <td>{{ \Carbon\Carbon::parse($user_permission->start_date)->format('d.m.Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($user_permission->end_date)->format('d.m.Y') }}</td>
                                            <td>{{ $user_permission->description }}</td>
                                            <td>
                                             @switch($user_permission->status)
                                                      @case(GlobalVariables::USER_PERM_STATUS_WAITING)
                                                          <span class="badge bg-warning">Bekliyor</span>
                                                          @break
                                             
                                                      @case(GlobalVariables::USER_PERM_STATUS_APPROVED)
                                                          <span class="badge bg-success">Onaylandı</span>
                                                          @break
                                             
                                                      @case(GlobalVariables::USER_PERM_STATUS_DECLINED)
                                                          <span class="badge bg-danger">Reddedildi</span>
                                                          @break
                                             
                                                      @default
                                                          <span class="badge bg-secondary">Bilinmiyor</span>
                                             @endswitch
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($user_permission->created_at)->format('d.m.Y H:i:s') }}</td>
                                            <td>
                                             <div class="d-flex align-items-center gap-1">
                                             @if($user_permission->status == GlobalVariables::USER_PERM_STATUS_WAITING)
                                                 <a href="{{ route('admin.user_permission.select', $user_permission->id) }}"
                                                     class="btn btn-sm btn-primary">
                                                     {{ __('user_permission.edit') }}
                                                 </a>
                                                 <form action="{{ route('admin.user_permission.delete', $user_permission->id) }}" method="POST"
                                                     onsubmit="return confirm('Bu izin türünü silmek istediğinize emin misiniz?');">
                                                     @csrf
                                                     <button type="submit" class="btn btn-sm btn-danger">
                                                         {{ __('user_permission.delete') }}
                                                     </button>
                                                     @php
                                                      $permissionOwner = $user_permission->user; // İzni oluşturan kullanıcı
                                                      @endphp
                                                 </form>
                                             @endif
                                             </div>
                                         </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-gray-500">
                                                {{ __('words.no_data_found') }}
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                            </table>
                            <div class="mt-3 d-flex justify-content-center">
                                {{ $user_permissions->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
@endsection
