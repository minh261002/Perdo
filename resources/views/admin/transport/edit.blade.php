@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa thông tin')

@push('styles')
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý vận chuyển
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.transport.index') }}">
                                    Quản lý vận chuyển
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
            <form action="{{ route('admin.transport.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $transport->id }}">

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin vận chuyển
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="transport_code" class="form-label">
                                            Mã vận chuyển
                                        </label>
                                        <input type="text" class="form-control" id="transport_code" name="transport_code"
                                            value="{{ $transport->transport_code }}" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="order_id" class="form-label">
                                            Vận chuyển đơn hàng
                                        </label>
                                        <input type="text" class="form-control" id="order_id" name="order_id"
                                            value="{{ $transport->order->order_code }}" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="user" class="form-label">
                                            Người nhận hàng
                                        </label>
                                        <input type="text" class="form-control" id="user" name="user"
                                            value="{{ $transport->order->name }}" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">
                                            Số điện thoại
                                        </label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $transport->order->phone }}" readonly>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="address" class="form-label">
                                            Địa chỉ
                                        </label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="{{ $transport->order->address }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    Tuỳ chọn
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="payment_method" class="form-label">
                                        Đơn vị vận chuyển
                                    </label>
                                    <select class="form-select" id="payment_method" name="payment_method" disabled>
                                        @foreach ($transportMethod as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $transport->method->value == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="payment_status" class="form-label">
                                        Trạng thái vận chuyển
                                    </label>
                                    <select name="status" class="form-select mb-3" id="order_status">
                                        @foreach ($transportStatus as $key => $value)
                                            @if (array_search($transport->statuses->last()->status->value, array_keys($transportStatus)) <=
                                                    array_search($key, array_keys($transportStatus)))
                                                <option value="{{ $key }}"
                                                    {{ $transport->statuses->last()->status->value == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endif
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
                                <a href="{{ route('admin.transport.index') }}" class="btn btn-secondary w-100">
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
@endpush
