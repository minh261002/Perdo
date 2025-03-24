@extends('admin.layouts.master')
@section('title', 'Thêm quản trị viên')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản trị viên
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.admin.index') }}">
                                    Quản trị viên
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Thêm mới
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <form action="{{ route('admin.admin.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin quản trị viên
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="name" class="form-label">
                                            Họ và tên
                                        </label>

                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name') }}">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="email" class="form-label">
                                            Email
                                        </label>

                                        <input type="text" class="form-control" name="email" id="email"
                                            value="{{ old('email') }}">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone" class="form-label">
                                            Số điện thoại
                                        </label>

                                        <input type="text" class="form-control" name="phone" id="phone"
                                            value="{{ old('phone') }}">

                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="role_id" class="form-label">Vai trò </label>
                                        <select name="role_id" id="role_id" class="form-control select2">
                                            <option value="">Chọn vai trò</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 form-group mb-3">
                                        @include('components.pick-address', [
                                            'label' => 'Địa chỉ cụ thể',
                                            'name' => 'address',
                                            'value' => old('address'),
                                        ])
                                        <input type="hidden" name="lat" value="{{ old('lat') }}">
                                        <input type="hidden" name="lng" value="{{ old('lng') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Mật khẩu</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="card-title mb-0">Ảnh đại diện</h2>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <span class="image img-cover image-target"><img class="w-100"
                                                src="{{ old('image') ? old('image') : asset('images/not-found.jpg') }}"
                                                alt=""></span>
                                        <input type="hidden" name="image" value="{{ old('image') }}">
                                    </div>
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
                                <a href="{{ route('admin.admin.index') }}" class="btn btn-secondary w-100">
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

    @include('components.modal-pick-address')
    @include('components.google-map-script')
@endsection

@push('scripts')
    <script src="{{ asset('js/finder.js') }}"></script>
    <script src="{{ asset('libs/litepicker/dist/litepicker.js?1692870487') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
    </script>
@endpush
