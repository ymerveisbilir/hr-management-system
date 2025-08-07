@extends('admin.layouts.app')
@section('title')
    @lang('device.title')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (isset($new) || isset($device))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                @include('admin.forms.device')
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('device.title') }}</h3>
                        <a class="btn btn-success text-white waves-effect waves-light" href="{{ route('admin.device.new') }}">
                            <i class="icon-base ti tabler-plus ms-2 icon-14px"></i>
                            <small class="align-middle">{{ __('words.new_add') }}</small>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device.name') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device.type') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device.serial_number') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device.description') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($devices as $device)
                                        <tr class="hover:bg-gray-100">
                                            <td>{{ $device->name }}</td>
                                            <td>{{ $device->type }}</td>
                                            <td>{{ $device->serial_number }}</td>
                                            <td>{{ $device->description }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="{{ route('admin.device.select', $device->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        {{ __('device.edit') }}
                                                    </a>
                                                    <form action="{{ route('admin.device.delete', $device->id) }}" method="POST"
                                                        onsubmit="return confirm('Bu cihazı silmek istediğinize emin misiniz?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            {{ __('device.delete') }}
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
