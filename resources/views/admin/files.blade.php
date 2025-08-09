@extends('admin.layouts.app')
@section('title')
    @lang('file.page_title')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (isset($new) || isset($file))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                @include('admin.forms.file')
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('file.page_title') }}</h3>
                        <a class="btn btn-success text-white waves-effect waves-light" href="{{ route('admin.file.new') }}">
                            <i class="icon-base ti tabler-plus ms-2 icon-14px"></i>
                            <small class="align-middle">{{ __('words.new_add') }}</small>
                        </a>
                    </div>
                    <div class="card-body">
                           <div class="d-flex justify-content-between align-items-center mb-3">
                                    <form action="{{ route('admin.file.index') }}" method="GET" class="d-flex" no-auto>
                                        <input
                                            type="text"
                                            name="search"
                                            class="form-control me-2"
                                            placeholder="@lang('words.search')"
                                            value="{{ old('search', $search) }}"
                                        />
                                        <button type="submit" class="btn btn-primary">@lang('words.search')</button>
                                        @if(!empty($search))
                                                      <a href="{{ route('admin.file.index') }}" class="btn btn-secondary">
                                                      @lang('words.clear')
                                                      </a>
                                         @endif
                                    </form>
                           </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('file.title') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('file.original_name') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($files as $file)
                                        <tr class="hover:bg-gray-100">
                                            <td>{{ $file->title }}</td>
                                            <td>{{ $file->original_name }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="{{ route('admin.file.select', $file->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        {{ __('file.edit') }}
                                                    </a>
                                                    <form action="{{ route('admin.file.delete', $file->id) }}" method="POST"
                                                        onsubmit="return confirm('Bu cihazı silmek istediğinize emin misiniz?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            {{ __('file.delete') }}
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
                           <div class="mt-3 d-flex justify-content-center">
                                    {{ $files->links('pagination::bootstrap-5') }}
                           </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
<script>
      $(document).ready(function() {
         $('.select2').select2();
      });
</script>
@endsection
