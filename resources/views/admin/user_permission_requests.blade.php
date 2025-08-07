@extends('admin.layouts.app')
@php
    use App\Http\Helpers\GlobalVariables;
@endphp
@section('title')
    @lang('user_permission.permission_request')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('user_permission.permission_request') }}</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user_permission.user') }}</th>
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
                                            <td>{{ $user_permission->user->name ." ". $user_permission->user->surname }}</td>
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
                                             @php
                                                      $permissionOwner = $user_permission->user; // İzni oluşturan kullanıcı
                                             @endphp
                                             @if($auth_user->id == $permissionOwner->approver_user && $user_permission->status == GlobalVariables::USER_PERM_STATUS_WAITING)
                                             <form action="{{ route('admin.user_permission.update_status', $user_permission->id) }}" method="POST" style="display:inline-block;">
                                                      @csrf
                                                      <input type="hidden" name="action" id="action_input" value="" />
                                                      <button type="submit" class="btn btn-success btn-sm" onclick="document.getElementById('action_input').value='1'">{{ __('user_permission.approve') }}</button>
                                                      <button type="submit" class="btn btn-danger btn-sm" onclick="document.getElementById('action_input').value='0'">{{ __('user_permission.decline') }}</button>
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
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
