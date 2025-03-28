@extends('admin.layouts.master')
@section('title', 'Thêm sản phẩm mới')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý sản phẩm
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.product.index') }}">
                                    Quản lý sản phẩm
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Thêm sản phẩm mới
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="page-body">
            <form action="{{ route('admin.product.update') }}" class="row" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="product[id]" value="{{ $product->id }}">

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title mb-0">Thông tin sản phẩm</h2>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="name" name="product[name]"
                                        value="{{ old('product[name]', $product->name) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="sku" name="product[sku]"
                                        value="{{ old('product[sku]', $product->sku) }}" readOnly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" id="stock" name="product[stock]"
                                        value="{{ old('product[stock]', $product->stock) }}">
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="price" class="form-label">Giá sản phẩm</label>
                                    <input type="text" class="form-control" id="price" name="product[price]"
                                        value="{{ old('product[price]', $product->price) }}">
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="sale_price" class="form-label">Giá khuyến mãi</label>
                                    <input type="text" class="form-control" id="sale_price" name="product[sale_price]"
                                        value="{{ old('product[sale_price]', $product->sale_price) }}">
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="desc" class="form-label">Mô tả</label>
                                    <textarea class="form-control ck-editor" id="desc" name="product[desc]" rows="5">{{ old('product[desc]', $product->desc) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h2 class="card-title mb-0">Bộ sưu tập ảnh</h2>
                            <div class="upload-album"><a href="" class="upload-picture">Tải lên</a></div>
                        </div>

                        <div class="card-body">
                            <div class="col-lg-12">
                                @php
                                    $gallery =
                                        old('gallery') ??
                                        (!empty($product->gallery) ? json_decode($product->gallery, true) : []);
                                @endphp

                                @if (empty($gallery) || count($gallery) == 0)
                                    <div class="click-to-upload">
                                        <div class="icon">
                                            <a href="" class="upload-picture">
                                                <svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                                    <path
                                                        d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="small-text">
                                            <p>Click vào nút "Tải lên" để thêm ảnh</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="upload-list {{ !empty($gallery) ? '' : 'hidden' }}">
                                    <ul id="sortable" class="clearfix data-album sortui ui-sortable">
                                        @foreach ($gallery as $key => $val)
                                            <li class="ui-state-default">
                                                <div class="thumb">
                                                    <span class="span image img-scaledown">
                                                        <img src="{{ $val }}" alt="{{ $val }}">
                                                        <input type="hidden" name="gallery[]"
                                                            value="{{ $val }}">
                                                    </span>
                                                    <button class="delete-image">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h2 class="card-title mb-0">SEO</h2>
                        </div>

                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="meta_title" class="form-label">Tiêu đề SEO</label>
                                <input type="text" class="form-control" id="meta_title" name="product[meta_title]"
                                    value="{{ old('product[meta_title]', $product->meta_title) }}">
                                <span class="error-title text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="meta_description" class="form-label">Mô tả SEO</label>
                                <textarea name="product[meta_desc]" class="form-control" id="meta_description">{{ old('product[meta_desc]', $product->meta_desc) }}</textarea>
                                <span class="error-desc text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="meta_keywords" class="form-label">Từ khóa SEO
                                    (Phân cách bằng dấu phẩy)
                                </label>
                                <input type="text" class="form-control" id="meta_keywords"
                                    name="product[meta_keywords]"
                                    value="{{ old('product[meta_keywords]', $product->meta_keywords) }}">
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
                            <div class="form-group">
                                <select name="product[status]" id="status" class="form-select">
                                    @foreach ($status as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('product[status]', $product->status->value) == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h2 class="card-title">Thương hiệu</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <select name="product[brand_id]" id="brand_id" class="form-select select2">
                                    <option value="">Chọn thương hiệu</option>
                                    @foreach ($brands as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('product[brand_id]', $product->brand_id) == $key ? 'selected' : '' }}>
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

                    <div class="card mt-5">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h2 class="card-title">Ảnh đại diện</h2>
                        </div>

                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span class="image img-cover image-target"><img class="w-100"
                                            src="{{ $product->image ?? asset('images/not-found.jpg') }}"
                                            alt=""></span>
                                    <input type="hidden" name="product[image]"
                                        value="{{ old('image', $product->image ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h2 class="card-title">Thao tác</h2>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.product.index') }}" class="w-100 btn btn-secondary">Quay lại</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="w-100 btn btn-primary">Lưu thay đổi</button>
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

            let list_categories = {{ json_encode($product->categories->pluck('id')) }};

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
