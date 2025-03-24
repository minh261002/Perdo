@extends('admin.layouts.master')
@section('title', 'Thêm chuyên mục bài viết mới')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý chuyên mục bài viết
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.post_catalogue.index') }}">
                                    Quản lý chuyên mục bài viết
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Thêm chuyên mục bài viết mới
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <form action="{{ route('admin.post_catalogue.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin chuyên mục bài viết
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">
                                            Tên chuyên mục
                                        </label>

                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name') }}">
                                    </div>


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="parent_id" class="form-label">
                                            Chuyên mục cha
                                        </label>

                                        <select class="form-select select2" name="parent_id" id="parent_id">
                                            <option value="">Chọn chuyên mục cha</option>
                                            @foreach ($catalogues as $catalogue)
                                                <option value="{{ $catalogue->id }}">
                                                    {{ generate_text_depth_tree($catalogue->depth) }}
                                                    {{ $catalogue->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="position" class="form-label">
                                            Vị trí
                                        </label>

                                        <input type="number" class="form-control" name="position" id="position"
                                            value="{{ old('position') }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="desc" class="form-label">
                                            Mô tả
                                        </label>

                                        <textarea class="ck-editor" name="desc" id="desc">{{ old('desc') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="card-title">SEO</h2>
                            </div>

                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="meta_title" class="form-label">Tiêu đề SEO</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        value="{{ old('meta_title') }}">
                                    <span class="error-title text-danger"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="meta_description" class="form-label">Mô tả SEO</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description">{{ old('meta_description') }}</textarea>
                                    <span class="error-desc text-danger"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="meta_keywords" class="form-label">Từ khóa SEO
                                        (Phân cách bằng dấu phẩy)
                                    </label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                        value="{{ old('meta_keywords') }}">
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
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Ảnh
                                </h3>
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
                                <a href="{{ route('admin.post_catalogue.index') }}" class="btn btn-secondary w-100">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
    </script>
@endpush
