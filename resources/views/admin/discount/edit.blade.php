@extends('layouts.master')
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
                        Quản lý mã giảm giá
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('discount.index') }}">
                                    Quản lý mã giảm giá
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
            <form action="{{ route('discount.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $discount->id }}" />

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin mã giảm giá
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="code" class="form-label">Mã</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            value="{{ $discount->code }}">
                                    </div>

                                    <div class="col-md-6
                                            mb-3">
                                        <label class="form-label" for="date_start" class="form-label">Ngày bắt đầu</label>
                                        <input type="text" class="form-control start-picker active" readonly="readonly"
                                            name="date_start" value="{{ $discount->date_start }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="date_end" class="form-label">Ngày kết thúc</label>
                                        <input type="text" class="form-control end-picker active" readonly="readonly"
                                            name="date_end" value="{{ $discount->date_end }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="max_usage">Lượt sử dụng</label>
                                        <input type="number" class="form-control" id="max_usage" name="max_usage"
                                            value="{{ $discount->max_usage }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="min_order_amount">Giá trị tối thiểu</label>
                                        <input type="number" class="form-control" id="min_order_amount"
                                            name="min_order_amount" value="{{ $discount->min_order_amount }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="type">Loại giảm giá</label>
                                        <select class="form-select" name="type" id="type">
                                            @foreach ($types as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $discount->type == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if ($discount->type == \App\Enums\Discount\DiscountType::Percentage->value)
                                        <div class="col-md-6 mb-3 d-none">
                                            <label class="form-label" for="value">Giá trị</label>
                                            <input type="number" class="form-control" id="percent_value"
                                                name="percent_value" value="{{ old('percent_value') }}" placeholder="%">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="value">Giá trị</label>
                                            <input type="number" class="form-control" id="discount_value"
                                                name="discount_value" value="{{ $discount->discount_value }}"
                                                placeholder="VNĐ">
                                        </div>
                                    @else
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="value">Giá trị</label>
                                            <input type="number" class="form-control" id="percent_value"
                                                name="percent_value" value="{{ $discount->percent_value }}"
                                                placeholder="%">
                                        </div>

                                        <div class="col-md-6 mb-3  d-none">
                                            <label class="form-label" for="value">Giá trị</label>
                                            <input type="number" class="form-control" id="discount_value"
                                                name="discount_value" value="{{ old('discount_value') }}"
                                                placeholder="VNĐ">

                                        </div>
                                    @endif

                                    <div class="col-md-6 mb-3">
                                        <label for="apply_for">Đối tượng áp dụng</label>
                                        <select name="apply_for" id="apply_for" class="form-select">
                                            @foreach ($applyFor as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $discount->apply_for == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if ($discount->apply_for == \App\Enums\Discount\DiscountApplyFor::One->value)
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="user_id[]">Khách hàng</label>
                                            <select class="form-control select2-user-load" name="user_id[]"
                                                id="user_id" multiple>
                                                @foreach ($member as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $discount->users->contains($user->id) ? 'selected' : '' }}>
                                                        {{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div class="col-12 mb-3 d-none">
                                        <label class="form-label" for="user_id[]">Khách hàng</label>
                                        <select class="form-control select2-user" name="user_id[]" id="user_id"
                                            multiple>
                                            @foreach ($member as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="desc" class="form-label">Mô tả</label>
                                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
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
                                                {{ $discount->status == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                <a href="{{ route('discount.index') }}" class="btn btn-secondary w-100">
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
    <script src="{{ asset('libs/litepicker/dist/litepicker.js?1692870487') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-user').select2({
                theme: 'bootstrap-5',
                width: '100%',
            });

            $('.select2-user-load').select2({
                theme: 'bootstrap-5',
                width: '100%',
            });

            $('#type').change(function() {
                let discountType = $(this).val();

                if (discountType == 2) {
                    $('#percent_value').parent().addClass('d-none');
                    $('#discount_value').parent().removeClass('d-none');
                } else {
                    $('#percent_value').parent().removeClass('d-none');
                    $('#discount_value').parent().addClass('d-none');
                }
            });

            $('#apply_for').change(function() {
                let applyFor = $(this).val();

                if (applyFor == 1) {
                    $('#user_id').parent().removeClass('d-none');
                } else {
                    $('#user_id').parent().addClass('d-none');
                }
            });
        });
    </script>

    <script>
        const picker = new Litepicker({
            element: document.querySelector('.start-picker'),
            format: 'YYYY-MM-DD',
            showDropdowns: true,
            minDate: new Date(),
            showWeekNumbers: false,
            singleMode: true,
            autoApply: true,
            autoRefresh: true,
            lang: 'vi-VN',
            mobileFriendly: true,
            resetButton: true,
            autoRefresh: true,
            dropdowns: {
                minYear: null,
                maxYear: null,
                months: true,
                years: true
            },
            setup: (picker) => {
                picker.on('selected', (date1, date2) => {
                    console.log(date1, date2);
                });
            }
        });

        const picker2 = new Litepicker({
            element: document.querySelector('.end-picker'),
            format: 'YYYY-MM-DD',
            showDropdowns: true,
            showWeekNumbers: false,
            singleMode: true,
            autoApply: true,
            autoRefresh: true,
            lang: 'vi-VN',
            mobileFriendly: true,
            resetButton: true,
            minDate: new Date(),
            autoRefresh: true,
            dropdowns: {
                minYear: null,
                maxYear: null,
                months: true,
                years: true
            },
            setup: (picker) => {
                picker.on('selected', (date1, date2) => {
                    console.log(date1, date2);
                });
            }
        });
    </script>
@endpush
