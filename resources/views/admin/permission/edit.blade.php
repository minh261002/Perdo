@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa thông tin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý quyền
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.permission.index') }}">
                                    Quản lý quyền
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Chỉnh sửa thông tin
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <form action="{{ route('admin.permission.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $permission->id }}">

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin quyền
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="name" class="form-label">
                                            Tiêu đề
                                        </label>

                                        <input type="text" class="form-control" name="title" id="title"
                                            value="{{ $permission->title }}">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="name" class="form-label">
                                            Nhóm quyền (GUARD_NAME)
                                        </label>

                                        <select name="guard_name" id="guard_name" class="form-control">
                                            <option value="admin"
                                                {{ $permission->guard_name == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="name" class="form-label">
                                            Quyền (PERMISSION_NAME)
                                        </label>

                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ $permission->name }}">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="module_id" class="form-label">
                                            Thuộc module
                                        </label>

                                        <select name="module_id" id="module_id" class="form-control select2">
                                            <option value="">Chọn module</option>
                                            @foreach ($modules as $module)
                                                <option value="{{ $module->id }}"
                                                    {{ $module->id == $permission->module_id ? 'selected' : '' }}>
                                                    {{ $module->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thao tác
                                </h3>
                            </div>

                            <div class="card-body d-flex align-items-center justify-content-between gap-4">
                                <a href="{{ route('admin.permission.index') }}" class="btn btn-secondary w-100">
                                    Quay lại
                                </a>

                                <button type="submit" class="btn btn-primary w-100">
                                    Lưu thay đổi
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
    </script>
@endpush
