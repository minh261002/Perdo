@extends('admin.layouts.master')
@section('title', 'Gửi thông báo')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý thông báo
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.notification.index') }}">
                                    Quản lý thông báo
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Gửi thông báo mới
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <form action="{{ route('admin.notification.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="card-title mb-0">Gửi thông báo</h2>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 form-group mb-3">
                                        <label class="form-label" for="types">Đối tượng</label>
                                        <select class="form-select" name="types" id="types">
                                            <option value="1">Thông báo tất cả</option>
                                            <option value="2">Thông báo cho khách hàng</option>
                                            <option value="3">Thông báo cho quản trị viên</option>
                                        </select>
                                    </div>

                                    <div class="col-12 form-group mb-3 d-none" id="user_type_container">
                                        <label class="form-label" for="user_types">Loại thông báo</label>
                                        <select class="form-select" name="user_types" id="user_types">
                                            <option value="">Chọn loại thông báo</option>
                                            <option value="1">Thông báo tất cả khách hàng</option>
                                            <option value="2">Thông báo cho khách hàng cụ thể</option>
                                        </select>
                                    </div>

                                    <div class="col-12 form-group mb-3 d-none" id="user_id_container">
                                        <label class="form-label" for="user_id">Chọn khách hàng</label>
                                        <select class="form-select select2" name="user_id[]" id="user_id"
                                            multiple="multiple">
                                            <option value="">Chọn khách hàng</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 form-group mb-3 d-none" id="admin_type_container">
                                        <label class="form-label" for="admin_types">Loại thông báo</label>
                                        <select class="form-select" name="admin_types" id="admin_types">
                                            <option value="">Chọn loại thông báo</option>
                                            <option value="1">Thông báo tất cả quản trị viên</option>
                                            <option value="2">Thông báo cho quản trị viên cụ thể</option>
                                        </select>
                                    </div>

                                    <div class="col-12 form-group mb-3 d-none" id="admin_id_container">
                                        <label class="form-label" for="admin_id">Chọn quản trị viên</label>
                                        <select class="form-select select2" name="admin_id[]" id="admin_id"
                                            multiple="multiple">
                                            <option value="">Chọn quản trị viên</option>
                                            @foreach ($admins as $admin)
                                                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 form-group mb-3">
                                        <label class="form-label" for="title">Tiêu đề</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Nhập tiêu đề">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 form-group mb-3">
                                        <label class="form-label" for="content">Nội dung</label>
                                        <textarea class="form-control ck-editor" name="content" id="content" rows="5" placeholder="Nhập nội dung"></textarea>
                                        @error('content')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="card-title mb-0">Thao tác</h2>
                            </div>

                            <div class="card-body">
                                <div class="col-12 mb-3">
                                    <button type="submit" class="w-100 btn btn-primary">Gửi thông báo</button>
                                </div>
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
    <script src="{{ asset('js/finder.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Chọn người nhận'
            });
        });

        $(document).ready(function() {
            var types = $('#types');
            var user_types = $('#user_types');
            var admin_types = $('#admin_types');
            var user_id_container = $('#user_id_container');
            var admin_id_container = $('#admin_id_container');
            var user_type_container = $('#user_type_container');
            var admin_type_container = $('#admin_type_container');

            types.on('change', function() {
                var value = $(this).val();

                if (value === '1') {
                    user_type_container.addClass('d-none');
                    admin_type_container.addClass('d-none');
                    user_id_container.addClass('d-none');
                    admin_id_container.addClass('d-none');
                } else if (value === '2') {
                    user_type_container.removeClass('d-none');
                    admin_type_container.addClass('d-none');
                    admin_id_container.addClass('d-none');
                } else if (value === '3') {
                    admin_type_container.removeClass('d-none');
                    user_type_container.addClass('d-none');
                    user_id_container.addClass('d-none');
                }
            });

            user_types.on('change', function() {
                if ($(this).val() === '2') {
                    user_id_container.removeClass('d-none');
                } else {
                    user_id_container.addClass('d-none');
                }
            });

            admin_types.on('change', function() {
                if ($(this).val() === '2') {
                    admin_id_container.removeClass('d-none');
                } else {
                    admin_id_container.addClass('d-none');
                }
            });
        });
    </script>
@endpush
