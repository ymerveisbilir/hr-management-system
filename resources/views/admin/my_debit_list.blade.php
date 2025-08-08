@extends('admin.layouts.app')
@section('title')
    @lang('device_assignment.title2')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.device_id') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.type') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.serial_number') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.note') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.returned_at') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('device_assignment.created_at') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($device_assignments as $device_assignment)
                                        <tr class="hover:bg-gray-100">
                                            <td>{{ $device_assignment->device->name }}</td>
                                            <td>{{ $device_assignment->device->type }}</td>
                                            <td>{{ $device_assignment->device->serial_number }}</td>
                                            <td>{{ $device_assignment->note }}</td>
                                            <td>
                                             @if ($device_assignment->returned_at)
                                                 {{ \Carbon\Carbon::parse($device_assignment->returned_at)->format('d.m.Y') }}
                                             @else
                                                 -
                                             @endif
                                             </td>
                                             <td>{{ $device_assignment->created_at->format('d.m.Y') }}</td>

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
