@extends('admin.layouts.app')
@section('title')
    @lang('user_permission_type.title')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (isset($new) || isset($user_permission_type))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                @include('admin.forms.user_permission_type')
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('user_permission_type.title') }}</h3>
                        <a class="btn btn-success text-white waves-effect waves-light" href="{{ route('admin.user_permission_type.new') }}">
                            <i class="icon-base ti tabler-plus ms-2 icon-14px"></i>
                            <small class="align-middle">{{ __('words.new_add') }}</small>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user_permission_type.name') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user_permission_type.created_at') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($user_permission_types as $user_permission_type)
                                        <tr class="hover:bg-gray-100">
                                            <td>{{ $user_permission_type->name }}</td>
                                            <td>{{ $user_permission_type->created_at }}</td>
                                            <td>
                                             <div class="d-flex align-items-center gap-1">
                                                 <a href="{{ route('admin.user_permission_type.select', $user_permission_type->id) }}"
                                                     class="btn btn-sm btn-primary">
                                                     {{ __('user_permission_type.edit') }}
                                                 </a>
                                                 <form action="{{ route('admin.user_permission_type.delete', $user_permission_type->id) }}" method="POST"
                                                     onsubmit="return confirm('Bu izin türünü silmek istediğinize emin misiniz?');">
                                                     @csrf
                                                     <button type="submit" class="btn btn-sm btn-danger">
                                                         {{ __('user_permission_type.delete') }}
                                                     </button>
                                                 </form>
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
            @endif
        </div>
    </div>
@endsection
@section('js')
@endsection
