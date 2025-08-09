@extends('admin.layouts.app')
@section('title')
    @lang('file_type.title')
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@php
    use App\Http\Helpers\GlobalVariables;
@endphp
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        @if (isset($new) || isset($file_type))
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('admin.forms.file_type')
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('file_type.title') }}</h3>
                    <a class="btn btn-success text-white waves-effect waves-light" href="{{ route('admin.file_type.new') }}">
                        <i class="icon-base ti tabler-plus ms-2 icon-14px"></i>
                        <small class="align-middle">{{ __('words.new_add') }}</small>
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <form action="{{ route('admin.file_type.index') }}" method="GET" class="d-flex" no-auto>
                            <input
                                type="text"
                                name="search"
                                class="form-control me-2"
                                placeholder="@lang('words.search')"
                                value="{{ old('search', $search) }}"
                            />
                            <button type="submit" class="btn btn-primary">@lang('words.search')</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr style="background-color: #2c3e50;">
                                    <th class="text-white py-2 px-4 border-bottom">{{ __('file_type.name2') }}</th>
                                    <th class="text-white py-2 px-4 border-bottom">{{ __('file_type.allowed_extensions') }}</th>
                                    <th class="text-white py-2 px-4 border-bottom">{{ __('file_type.status') }}</th>
                                    <th class="text-white py-2 px-4 border-bottom">{{ __('file_type.created_at') }}</th>
                                    <th class="text-white py-2 px-4 border-bottom"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse ($file_types as $file_type)
                                    <tr class="hover:bg-gray-100">
                                        <td>{{ $file_type->name }}</td>
                                        <td>{{ implode(',', $file_type->allowed_extensions ?? []) }}</td>
                                        <td>
                                            @if ($file_type->is_active == GlobalVariables::FILE_STATUS_PASSIVE)
                                                <span class="badge bg-danger">{{ __('words.passive') }}</span>
                                            @else
                                                <span class="badge bg-success">{{ __('words.active') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $file_type->created_at->format('d.m.Y') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1">
                                                <a href="{{ route('admin.file_type.select', $file_type->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    {{ __('file_type.edit') }}
                                                </a>
                                                <form no-auto action="{{ route('admin.file_type.delete', $file_type->id) }}" method="POST"
                                                    onsubmit="return confirm('Bu dosya türünü silmek istediğinize emin misiniz?');">
                                                  @csrf
                                                  <button type="submit" class="btn btn-sm btn-danger">
                                                      {{ __('file_type.delete') }}
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
                           {{ $file_types->links('pagination::bootstrap-5') }}
                       </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('js')
<!-- jQuery (eğer zaten yoksa) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
         $(document).ready(function() {
             $('.select2').select2({
                 placeholder: "Kullanıcı seçin",
                 allowClear: true,
                 width: '100%'
             });
         });
     </script>
@endsection
