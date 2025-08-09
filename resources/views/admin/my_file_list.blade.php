@extends('admin.layouts.app')
@section('title')
    @lang('file.title2')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-2">{{ __('file.title2') }}</h3>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <form action="{{ route('admin.file.my_file_list') }}" method="GET" class="d-flex" no-auto>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control me-2"
                                    placeholder="@lang('words.search')"
                                    value="{{ old('search', $search) }}"
                                />
                                <button type="submit" class="btn btn-primary">@lang('words.search')</button>
                                @if(!empty($search))
                                              <a href="{{ route('admin.file.my_file_list') }}" class="btn btn-secondary">
                                              @lang('words.clear')
                                              </a>
                                 @endif
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('file.user_id') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('file.title') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('file.original_name') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('file.file_type_id') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('file.created_at') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($files as $file)
                                        <tr class="hover:bg-gray-100">
                                            <td>{{ $file->uploader->name ." ".  $file->uploader->surname}}</td>
                                            <td>{{ $file->title }}</td>
                                            <td>
                                             <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                               {{ $file->original_name }}
                                             </a>
                                           </td>                                            <td>{{ $file->fileType->name }}</td>
                                            <td>{{ $file->created_at->format('d.m.Y') }}</td>
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
                                {{ $files->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
