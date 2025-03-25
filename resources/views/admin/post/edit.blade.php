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
                        Quản lý bài viết
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.post.index') }}">
                                    Quản lý bài viết
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
            <form action="{{ route('admin.post.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $post->id }}">

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin bài viết
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label">
                                            Tiêu đề
                                        </label>

                                        <input type="text" class="form-control" name="title" id="title"
                                            value="{{ old('title', $post->title) }}">

                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="desc" class="form-label">
                                            Nội dung
                                        </label>

                                        <textarea class="ck-editor" name="content" id="content">{{ old('content', $post->content) }}</textarea>

                                        @error('content')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                        value="{{ old('meta_title', $post->meta_title) }}">
                                    <span class="error-title text-danger"></span>
                                    @error('meta_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="meta_description" class="form-label">Mô tả SEO</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description">{{ old('meta_description', $post->meta_description) }}</textarea>
                                    <span class="error-desc text-danger"></span>
                                    @error('meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="meta_keywords" class="form-label">Từ khóa SEO
                                        (Phân cách bằng dấu phẩy)
                                    </label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                        value="{{ old('meta_keywords', $post->meta_keywords) }}">
                                    @error('meta_keywords')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h2 class="card-title">Chuyên mục</h2>
                            </div>

                            <div class="card-body">
                                <div class="form-group mb-3" id="catalogues_result">

                                    @error('catalogue_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
                                <div class="form-group mb-3">
                                    <label for="catalogue_id" class="form-label">
                                        Trạng thái
                                    </label>
                                    <select class="form-select" name="status" id="status">
                                        @foreach ($status as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('status', $post->status) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="is_featured" class="form-label">
                                        Tuỳ chọn
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_featured"
                                            value="1"
                                            {{ old('is_featured', $post->is_feature) == true ? 'checked' : '' }}>
                                        <span class="form-check-label">Bài viết nổi bật</span>
                                    </label>
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
                                                src="{{ old('image', $post->image ?? '') ? old('image', $post->image ?? '') : asset('admin/images/not-found.jpg') }}"
                                                alt=""></span>
                                        <input type="hidden" name="image"
                                            value="{{ old('image', $post->image ?? '') }}">
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
                                <a href="{{ route('admin.post.index') }}" class="btn btn-secondary w-100">
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

        $(document).ready(function() {
            let offset = 0;
            let totalCategories = 0;
            const limit = 10;
            let keyword = '';

            let list_catalogues = {{ json_encode($post->catalogues->pluck('id')) }};

            function getCategories(hidePrevious = false) {
                let url = "{{ route('admin.post_catalogue.get') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        offset: offset,
                        search: keyword
                    },
                    beforeSend: function() {
                        $('#catalogues_result').append(
                            '<div class="d-flex align-items-center justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                        );
                    },
                    success: function(response) {
                        let catalogues = response.catalogues;
                        totalcatalogues = response.total;
                        let html = '';

                        catalogues.forEach(catalogue => {
                            html += `
                                <div class="form-check" style="margin-left: ${catalogue.depth * 20}px;">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="${catalogue.id}"
                                        name="catalogue_id[]"
                                        data-lft="${catalogue._lft}"
                                        data-rgt="${catalogue._rgt}"
                                        id="catalogue_id-${catalogue.id}"
                                        ${list_catalogues.includes(catalogue.id) ? 'checked' : ''}
                                        >
                                    <label class="form-check-label" for="catalogue_id-${catalogue.id}">
                                        ${catalogue.name}
                                    </label>
                                </div>
                            `;
                        });

                        if (hidePrevious) {
                            $('#catalogues_result').html(html);
                        } else {
                            $('#catalogues_result').append(html);
                        }

                        if (offset + catalogues.length >= totalcatalogues) {
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
                        $('#catalogues_result').find('.spinner-border').remove();
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
