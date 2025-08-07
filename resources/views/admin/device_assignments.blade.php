@extends('admin.layouts.app')
@section('title')
    @lang('device_assignment.title')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (isset($new) || isset($device_assignment))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                @include('admin.forms.device_assignment')
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('device_assignment.title') }}</h3>
                        <a class="btn btn-success text-white waves-effect waves-light" href="{{ route('admin.device_assignment.new') }}">
                            <i class="icon-base ti tabler-plus ms-2 icon-14px"></i>
                            <small class="align-middle">{{ __('words.new_add') }}</small>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.user_id') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.device_id') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.returned_at') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.created_at') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($device_assignments as $device_assignment)
                                        <tr class="hover:bg-gray-100">
                                             <td>{{ $device_assignment->user->name . ' ' . $device_assignment->user->surname }}</td>
                                            <td>{{ $device_assignment->device->name }}</td>
                                            <td>
                                             @if ($device_assignment->returned_at)
                                                 {{ \Carbon\Carbon::parse($device_assignment->returned_at)->format('d.m.Y') }}
                                             @else
                                                 -
                                             @endif
                                             </td>
                                             <td>{{ $device_assignment->created_at->format('d.m.Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="{{ route('admin.device_assignment.select', $device_assignment->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        {{ __('device_assignment.edit') }}
                                                    </a>
                                                    <form action="{{ route('admin.device_assignment.delete', $device_assignment->id) }}" method="POST"
                                                        onsubmit="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            {{ __('device_assignment.delete') }}
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
