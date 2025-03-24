@extends('admin.layout.master')
@section('title', 'Chỉnh sửa slider')

@push('styles')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý slider
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.slider.index') }}">
                                    Quản lý slider
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Thêm slider mới
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <form action="{{ route('admin.slider.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $slider->id }}">

                <div class="row">

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="card-title mb-0">Thêm slider mới</h2>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Tên slider</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $slider->name }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="key" class="form-label">Key</label>
                                        <input type="text" class="form-control" id="key" name="key"
                                            value="{{ $slider->key }}">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="guard_name" class="form-label">Mô tả </label>
                                        <textarea name="desc" id="desc" class="ck-editor form-control" rows="5">{{ $slider->desc }}</textarea>

                                        @error('desc')
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
                                <h2 class="card-title">Trạng thái</h2>
                            </div>
                            <div class="card-body">
                                <div class="col-12 mb-3">
                                    <select name="status" id="status" class="form-control">
                                        @foreach ($status as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $slider->status == $key ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="card-title">Thao tác</h2>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <a href="{{ route('admin.slider.index') }}" class="w-100 btn btn-secondary">Quay
                                        lại</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="w-100 btn btn-primary">Lưu thay đổi</button>
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
    <script src="{{ asset('admin/js/finder.js') }}"></script>
@endpush
