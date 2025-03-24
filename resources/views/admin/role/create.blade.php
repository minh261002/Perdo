@extends('admin.layouts.master')
@section('title', 'Thêm vai trò mới')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý vai trò
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.role.index') }}">
                                    Quản lý vai trò
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Thêm vai trò mới
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <form action="{{ route('admin.role.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin vai trò
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 form-group mb-3">
                                        <label for="name" class="form-label">
                                            Tiêu đề
                                        </label>

                                        <input type="text" class="form-control" name="title" id="title"
                                            value="{{ old('title') }}">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="name" class="form-label">
                                            Vai trò (ROLE_NAME)
                                        </label>

                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name') }}">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="guard_name" class="form-label">
                                            Nhóm quyền (GUARD_NAME)
                                        </label>

                                        <select name="guard_name" id="guard_name" class="form-control">
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="permissions" class="form-label">Phân quyền</label>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                            <label class="form-check-label" for="checkAll">
                                                Chọn tất cả quyền
                                            </label>
                                        </div>

                                        <div class="row">
                                            @foreach ($modules as $module)
                                                <div class="col-md-3 mb-3">
                                                    <div class="card">
                                                        <div class="card-header pb-0">
                                                            <div class="form-check">
                                                                <input class="form-check-input module-check-all"
                                                                    type="checkbox"
                                                                    id="moduleCheckAll{{ $module['module_name'] }}"
                                                                    data-module-id="{{ $module['module_name'] }}">
                                                                <label class="form-check-label"
                                                                    for="moduleCheckAll{{ $module['module_name'] }}">
                                                                    {{ $module['module_name'] }}
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="card-body">
                                                            @if (isset($module['list']) && is_iterable($module['list']))
                                                                @foreach ($module['list'] as $permission)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input permission-check"
                                                                            type="checkbox"
                                                                            id="permissionCheck{{ $permission->id }}"
                                                                            data-module-id="{{ $module['module_name'] }}"
                                                                            name="permissions[]"
                                                                            value="{{ $permission->id }}">
                                                                        <label class="form-check-label"
                                                                            for="permissionCheck{{ $permission->id }}">
                                                                            {{ $permission->title }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <p>No permissions available for this module.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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
                                <a href="{{ route('admin.role.index') }}" class="btn btn-secondary w-100">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
        $(document).ready(function() {
            $('#checkAll').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('.module-check-all, .permission-check').prop('checked', isChecked);
            });

            $('.module-check-all').on('change', function() {
                var moduleId = $(this).data('module-id');
                var isChecked = $(this).is(':checked');
                $('.permission-check[data-module-id="' + moduleId + '"]').prop('checked', isChecked);

                updateCheckAllStatus();
            });

            $('.permission-check').on('change', function() {
                var moduleId = $(this).data('module-id');
                var allCheckedInModule = $('.permission-check[data-module-id="' + moduleId + '"]')
                    .length ===
                    $('.permission-check[data-module-id="' + moduleId + '"]:checked').length;

                $('#moduleCheckAll' + moduleId).prop('checked', allCheckedInModule);

                updateCheckAllStatus();
            });

            function updateCheckAllStatus() {
                var allModulesChecked = $('.module-check-all').length === $('.module-check-all:checked').length;
                var allPermissionsChecked = $('.permission-check').length === $('.permission-check:checked').length;

                $('#checkAll').prop('checked', allModulesChecked && allPermissionsChecked);
            }
        });
    </script>
@endpush
