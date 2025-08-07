@extends('admin.layouts.app')
@section('title')
    @lang('user.title')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if (isset($new) || isset($user))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                @include('admin.forms.user')
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('user.users') }}</h3>
                        <a class="btn btn-success text-white waves-effect waves-light" href="{{ route('admin.user.new') }}">
                            <i class="icon-base ti tabler-plus ms-2 icon-14px"></i>
                            <small class="align-middle">{{ __('words.new_add') }}</small>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr style="background-color: #2c3e50;">
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user.name_surname') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user.email') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user.user_title') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom">{{ __('user.created_at') }}</th>
                                        <th class="text-white py-2 px-4 border-bottom"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @forelse ($users as $user)
                                        <tr class="hover:bg-gray-100">
                                            <td>{{ $user->name . ' ' . $user->surname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->title }}</td>
                                            <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="{{ route('admin.user.select', $user->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        {{ __('user.edit') }}
                                                    </a>
                                                    <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            {{ __('user.delete') }}
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
