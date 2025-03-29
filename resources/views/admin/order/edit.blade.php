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
                        Quản lý thương hiệu
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.brand.index') }}">
                                    Quản lý thương hiệu
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
            <form action="{{ route('admin.brand.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $brand->id }}">

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin thương hiệu
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">
                                            Tên thương hiệu
                                        </label>

                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ $brand->name }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="description" class="form-label">
                                            Mô tả
                                        </label>

                                        <textarea class="ck-editor" name="description" id="description">{{ $brand->description }}</textarea>
                                    </div>
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
                                            <option value="{{ $key }}"
                                                {{ $brand->status == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-5">
                            <div class="card-header d-flex flex-column align-items-start justify-content-between gap-4">
                                <h2 class="card-title">Danh mục sản phẩm</h2>

                                <input type="text" class="form-control" id="search_category"
                                    placeholder="Tìm kiếm danh mục">
                            </div>
                            <div class="card-body">
                                <div class="form-group" id="categories_result">
                                </div>

                                <div class="text-center mt-3">
                                    <p id="loadMoreCategory" style="cursor:pointer">Xem thêm</p>
                                    <p id="hideCategory" class="hidden" style="cursor:pointer">Ẩn bớt</p>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Tuỳ chọn
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" name="show_home" value="1"
                                            {{ $brand->show_home ? 'checked' : '' }}>
                                        <span class="form-check-label">Hiển thị trang chủ</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h2 class="card-title">Logo</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <span class="image img-cover image-target"><img class="w-100"
                                                    src="{{ old('logo', $brand->logo) ? old('logo', $brand->logo) : asset('images/not-found.jpg') }}"
                                                    alt=""></span>
                                            <input type="hidden" name="logo" value="{{ old('logo', $brand->logo) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h2 class="card-title">Banner</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <span class="image img-cover image-target"><img class="w-100"
                                                    src="{{ old('banner', $brand->banner) ? old('banner', $brand->banner) : asset('images/not-found.jpg') }}"
                                                    alt=""></span>
                                            <input type="hidden" name="banner"
                                                value="{{ old('banner', $brand->banner) }}">
                                        </div>
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
                                <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary w-100">
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
    <script src="{{ asset('js/finder.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
    </script>
    <script>
        $(document).ready(function() {
            let offset = 0;
            let totalCategories = 0;
            const limit = 10;
            let keyword = '';

            let list_categories = {{ json_encode($brand->categories->pluck('id')) }};

            function getCategories(hidePrevious = false) {
                let url = "{{ route('admin.category.get') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        offset: offset,
                        search: keyword
                    },
                    beforeSend: function() {
                        $('#categories_result').append(
                            '<div class="d-flex align-items-center justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                        );
                    },
                    success: function(response) {
                        let categories = response.categories;
                        totalCategories = response.total;
                        let html = '';

                        categories.forEach(category => {
                            html += `
                                <div class="form-check" style="margin-left: ${category.depth * 20}px;">
                                    <input class="form-check-input"
                                        type="checkbox" value="${category.id}"
                                        name="category_id[]"
                                        data-lft="${category._lft}"
                                        data-rgt="${category._rgt}"
                                        id="category_id-${category.id}"
                                        ${list_categories.includes(category.id) ? 'checked' : ''}
                                        >
                                    <label class="form-check-label" for="category_id-${category.id}">
                                        ${category.name}
                                    </label>
                                </div>
                            `;

                        });

                        if (hidePrevious) {
                            $('#categories_result').html(html);
                        } else {
                            $('#categories_result').append(html);
                        }

                        if (offset + categories.length >= totalCategories) {
                            $('#loadMoreCategory').hide();
                        } else {
                            $('#loadMoreCategory').show();
                        }

                        if (offset > 0) {
                            $('#hideCategory').show();
                        } else {
                            $('#hideCategory').hide();
                        }
                    },
                    complete: function() {
                        $('#categories_result').find('.spinner-border').remove();
                    }
                });
            }

            $('#loadMoreCategory').click(function() {
                offset += limit;
                getCategories();
            });

            $('#hideCategory').click(function() {
                offset = 0;
                getCategories(true);
            });

            $('#search_category').on('input', function() {
                clearTimeout($.data(this, 'timer'));
                let search = $(this).val();
                $(this).data('timer', setTimeout(function() {
                    keyword = search;
                    offset = 0;
                    getCategories(true);
                }, 500));
            });

            getCategories();
        })

        $(document).on('change', 'input[type="checkbox"]', function() {
            let lft = $(this).data('lft');
            let rgt = $(this).data('rgt');
            let checked = $(this).prop('checked');

            if (checked) {
                $('input[type="checkbox"]').each(function() {
                    let parentLft = $(this).data('lft');
                    let parentRgt = $(this).data('rgt');

                    if (parentLft < lft && parentRgt > rgt) {
                        $(this).prop('checked', true);
                    }
                });
            } else {
                $('input[type="checkbox"]').each(function() {
                    let parentLft = $(this).data('lft');
                    let parentRgt = $(this).data('rgt');

                    if (parentLft < lft && parentRgt > rgt) {
                        $(this).prop('checked', false);
                    }
                });
            }
        });
    </script>
@endpush
