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
                                Chỉnh sửa thông tin
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <form action="{{ route('admin.admin.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $admin->id }}">

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
                                            value="{{ old('name', $admin->name ?? '') }}">

                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="email" class="form-label">
                                            Email
                                        </label>

                                        <input type="text" class="form-control" name="email" id="email"
                                            value="{{ old('email', $admin->email ?? '') }}">

                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone" class="form-label">
                                            Số điện thoại
                                        </label>

                                        <input type="text" class="form-control" name="phone" id="phone"
                                            value="{{ old('phone', $admin->phone ?? '') }}">

                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="role_id" class="form-label">
                                            Vai trò
                                        </label>
                                        <select name="role_id" id="role_id" class="form-control select2">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $admin->role->contains($role->id) ? 'selected' : '' }}>

                                                    {{ $role->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 form-group mb-3">
                                        @include('components.pick-address', [
                                            'label' => 'Địa chỉ cụ thể',
                                            'name' => 'address',
                                            'value' => old('address', $admin->address ?? ''),
                                        ])
                                        <input type="hidden" name="lat" value="{{ old('lat', $admin->lat ?? '') }}">
                                        <input type="hidden" name="lng" value="{{ old('lng', $admin->lng ?? '') }}">
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
                                                src="{{ old('image', $admin->image ?? '') ? old('image', $admin->image ?? '') : asset('admin/images/not-found.jpg') }}"
                                                alt=""></span>
                                        <input type="hidden" name="image"
                                            value="{{ old('image', $admin->image ?? '') }}">
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
                                    Lưu thay đổi
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
    <script src="{{ asset('admin/js/finder.js') }}"></script>
    <script src="{{ asset('admin/libs/litepicker/dist/litepicker.js?1692870487') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
    </script>
@endpush
