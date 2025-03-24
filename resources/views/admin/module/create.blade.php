@extends('admin.layouts.master')
@section('title', 'Thêm module mới')

@push('styles')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý module
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.module.index') }}">
                                    Module
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Thêm module mới
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <form action="{{ route('admin.module.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin module
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">
                                        Tên module
                                    </label>

                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label for="description" class="form-label">
                                        Mô tả
                                    </label>

                                    <textarea class="ck-editor" name="description" id="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Trạng thái
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <select class="form-select" name="status" id="status">
                                        @foreach ($status as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thao tác
                                </h3>
                            </div>

                            <div class="card-body d-flex align-items-center justify-content-between gap-4">
                                <a href="{{ route('admin.module.index') }}" class="btn btn-secondary w-100">
                                    Quay lại
                                </a>

                                <button type="submit" class="btn btn-primary w-100">
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/finder.js') }}"></script>
@endpush
