@extends('admin.layouts.master')
@section('title', 'Thêm slider mới')

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
            <form action="{{ route('admin.slider.store') }}" method="POST">
                @csrf

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
                                            value="{{ old('name') }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="key" class="form-label">Key</label>
                                        <input type="text" class="form-control" id="key" name="key"
                                            value="{{ old('key') }}">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="desc" class="form-label">Mô tả </label>
                                        <textarea name="desc" id="desc" class="ck-editor form-control" rows="5"></textarea>
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
                                            <option value="{{ $key }}">{{ $value }}</option>
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
                                    <button type="submit" class="w-100 btn btn-primary">Thêm mới</button>
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
    <script src="{{ asset('/js/finder.js') }}"></script>
@endpush
