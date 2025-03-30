@extends('admin.layouts.master')
@section('title', 'Đơn hàng ' . $order->order_code)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-header d-print-none">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">
                        Quản lý đơn hàng
                    </h3>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.order.index') }}">
                                    Quản lý đơn hàng
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
            <form action="{{ route('admin.order.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $order->id }}">

                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin đơn hàng
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="order_code" class="form-label">Mã đơn hàng</label>
                                        <input type="text" name="order_code" id="order_code" class="form-control"
                                            value="{{ $order->order_code }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="name" class="form-label">Tên khách hàng</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ $order->name }}" readonly>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                            value="{{ $order->email }}" readonly>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ $order->phone }}" readonly>
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="address" class="form-label">Địa chỉ</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            value="{{ $order->address }}" readonly>
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <textarea name="note" id="note" class="form-control" rows="3" readonly>{{ $order->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title">
                                    Thông tin giỏ hàng
                                </h3>
                                @if ($order->statuses && $order->statuses->last()->status->value != \App\Enums\Order\OrderStatus::Cancelled->value)
                                    @if (!$order->transport)
                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal-delivery">
                                            <i class="ti ti-truck-delivery fs-2 me-2"></i>
                                            vận chuyển
                                        </a>
                                    @endif
                                @endif
                            </div>

                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-end">Giá</th>
                                            <th class="text-end">Tạm tính</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <p class="strong mb-1">
                                                        {{ $item->product->name }}
                                                    </p>
                                                    <div class="text-secondary">
                                                        {{-- {{ $item->s }} --}}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="text-end">
                                                    {{ format_price($item->price) }}
                                                </td>
                                                <td class="text-end">
                                                    {{ format_price($item->quantity * $item->price) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Mã giảm giá
                                </h3>
                            </div>

                            <div class="card-body">
                                @if ($order->discounts && $order->discounts->count() > 0)
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Mã giảm giá</th>
                                                <th>Giảm giá</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($order->discounts as $discount)
                                                <tr>
                                                    <td>{{ $discount->code }}
                                                        {{ $discount->description ? ' - ' . $discount->description : '' }}
                                                    </td>
                                                    <td>
                                                        @if ($discount->type->value == \App\Enums\Discount\DiscountType::Percentage->value)
                                                            {{ $discount->percent_value }}%
                                                        @else
                                                            {{ format_price($discount->discount_value) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info">
                                        Đơn hàng này không áp dụng mã giảm giá
                                    </div>
                                @endif
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
                                <select name="status" class="form-select mb-3" id="order_status">
                                    @foreach ($orderStatus as $key => $value)
                                        @if (array_search($order->statuses->last()->status->value, array_keys($orderStatus)) <=
                                                array_search($key, array_keys($orderStatus)))
                                            <option value="{{ $key }}"
                                                {{ $order->statuses->last()->status->value == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                <div class="form-group" id="cancel_reason" hidden>
                                    <label class="form-label">Lý do huỷ đơn hàng</label>
                                    <textarea class="form-control" name="cancel_reason" rows="3">{{ $order->cancel_reason }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin thanh toán
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                                    <select class="form-select" name="payment_method" id="payment_method" disabled>
                                        @foreach ($paymentMethods as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $key == $order->transaction->payment_method->value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="payment_method" class="form-label">Trạng thái thanh toán</label>
                                    <select class="form-select" name="payment_method" id="payment_method" disabled>
                                        @foreach ($paymentStatus as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $key == $order->transaction->payment_status->value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <a href="{{ route('admin.transaction.edit', $order->transaction->id) }}">
                                    Xem thông tin chi tiết giao dịch
                                </a>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thông tin vận chuyển
                                </h3>
                            </div>

                            <div class="card-body">
                                @if ($order->transport)

                                    <div class="form-group mb-3">
                                        <label for="payment_method" class="form-label">Đơn vị vận chuyển</label>
                                        <select class="form-select" name="payment_method" id="payment_method" disabled>
                                            @foreach ($deliveryMethod as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $key == $order->transport->method ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="payment_method" class="form-label">Trạng thái vận chuyển</label>
                                        <select class="form-select" name="payment_method" id="payment_method" disabled>
                                            @foreach ($deliveryStatus as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $key == $order->transaction->status ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <a href="{{ route('admin.transport.edit', $order->transport->id) }}">
                                        Xem thông tin chi tiết vận chuyển
                                    </a>
                                @else
                                    <div class="alert alert-info">
                                        Đơn hàng chưa được bàn giao vận chuyển
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Thao tác
                                </h3>
                            </div>

                            <div class="card-body d-flex align-items-center justify-content-between gap-4">
                                <a href="{{ route('admin.order.index') }}" class="btn btn-secondary w-100">
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

    <form class="modal modal-blur fade" id="modal-delivery" tabindex="-1" role="dialog" aria-hidden="true"
        method="POST" action="{{ route('admin.transport.store') }}">
        @csrf

        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vận chuyển đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mb-3">
                        <label for="method" class="form-label">Chọn đơn vị vận chuyển</label>
                        <select name="method" id="method" class="form-select">
                            @foreach ($deliveryMethod as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="create-delivery">Bàn giao vận chuyển</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap-5'
        });

        let cancelStatus = {{ $order->statuses->last()->status->value == 'cancelled' ? 'true' : 'false' }};

        if (cancelStatus) {
            $('#cancel_reason').removeAttr('hidden');
        }

        $('#order_status').change(function() {
            let status = $(this).val();

            if (status == 'cancelled') {
                $('#cancel_reason').removeAttr('hidden');
            } else {
                $('#cancel_reason').attr('hidden', true);
            }
        })
    </script>
@endpush
