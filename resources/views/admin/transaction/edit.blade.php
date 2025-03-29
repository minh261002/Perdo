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
                        Quản lý giao dịch
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.transaction.index') }}">
                                    Quản lý giao dịch
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
            <form action="{{ route('admin.transaction.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $transaction->id }}">

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin giao dịch
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="transaction_code" class="form-label">
                                            Mã giao dịch
                                        </label>
                                        <input type="text" class="form-control" id="transaction_code"
                                            name="transaction_code" value="{{ $transaction->transaction_code }}" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="transaction_code" class="form-label">
                                            Số tiền giao dịch
                                        </label>
                                        <input type="text" class="form-control" id="amount" name="amount"
                                            value="{{ format_price($transaction->amount) }}" readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="user_id" class="form-label">
                                            Người thanh toán
                                        </label>
                                        <input type="text" class="form-control" id="user_id" name="user_id"
                                            value="{{ $transaction->user_id ? $transaction->user->name : $transaction->order->name }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="order_id" class="form-label">
                                            Thanh toán đơn hàng
                                        </label>
                                        <input type="text" class="form-control" id="order_id" name="order_id"
                                            value="{{ $transaction->order->order_code }}" readonly>
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
                                        Phương thức thanh toán
                                    </label>
                                    <select class="form-select" id="payment_method" name="payment_method" disabled>
                                        @foreach ($paymentMethods as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $transaction->payment_method->value == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="payment_status" class="form-label">
                                        Trạng thái thanh toán
                                    </label>
                                    <select class="form-select" id="payment_status" name="payment_status">
                                        {{-- @foreach ($paymentStatuses as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $transaction->payment_status->value == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach --}}

                                        @foreach ($paymentStatuses as $key => $value)
                                            @if ($transaction->payment_status->value == $key)
                                                <option value="{{ $key }}"
                                                    {{ $transaction->payment_status->value == $key ? 'selected' : '' }}>
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
                                <a href="{{ route('admin.transaction.index') }}" class="btn btn-secondary w-100">
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
