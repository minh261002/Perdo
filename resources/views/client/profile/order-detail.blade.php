@extends('client.layout.master')
@section('title', 'Đơn hàng' . ' - ' . $order->order_code)


@section('content')
    <div class="my-30px">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    @include('client.profile.components.left-side')

                    <div class="col-12 col-md-10 d-flex flex-column">
                        <div class="card-body">
                            <div class="mb-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h2 class="mb-1">Đơn hàng #{{ $order->order_code }}</h2>
                                    <p class="text-secondary">
                                        Ngày đặt hàng: {{ format_datetime($order->created_at) }}
                                    </p>
                                </div>
                                @if ($order->statuses->last()->status->value == \App\Enums\Order\OrderStatus::Pending->value)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#cancelOrderModal">
                                        Huỷ đơn hàng
                                    </button>
                                @else
                                    <span
                                        @class([
                                            'badge',
                                            App\Enums\Order\OrderStatus::from(
                                                $order->statuses->last()->status->value)->badge(),
                                        ])>{{ \App\Enums\Order\OrderStatus::getDescription($order->statuses->last()->status->value) }}</span>
                                @endif
                            </div>
                            <div class="mb-4">
                                <div class="alert alert-info">
                                    <strong>Thông tin đơn hàng</strong>
                                    <p class="mb-0">
                                        Trạng thái thanh toán:
                                        <span
                                            @class([
                                                'badge',
                                                App\Enums\Transaction\PaymentStatus::from(
                                                    $order->transaction->payment_status->value)->badge(),
                                            ])>{{ \App\Enums\Transaction\PaymentStatus::getDescription($order->transaction->payment_status->value) }}</span>
                                    </p>
                                    <p class="mb-0">
                                        Phương thức thanh toán:
                                        {{ \App\Enums\Transaction\PaymentMethod::getDescription($order->transaction->payment_method->value) }}
                                    </p>
                                </div>
                            </div>
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

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Tạm tính</th>
                                                    <th></th>
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
                                                            <span class="text-secondary">
                                                                {{ format_price($item->price) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ format_price($item->price) }}</td>
                                                        <td>
                                                            <i class="ti ti-star fs-2 text-warning"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-blur fade" id="cancelOrderModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                    <i class="ti ti-alert-triangle text-danger" style="font-size: 64px"></i>
                    <h3>
                        Cảnh báo
                    </h3>
                    <div class="text-secondary">
                        Đơn hàng sẽ bị bị huỷ.
                        <br>
                        Nếu bạn đã thanh toán đơn hàng này, số tiền sẽ được hoàn lại vào tài khoản của bạn.
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <form class="row" action="{{ route('profile.order.cancel', $order->order_code) }}"
                            method="POST">
                            @csrf
                            <div class="col-12 mb-3">
                                <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="3"
                                    placeholder="Nhập lý do huỷ đơn hàng"></textarea>
                            </div>
                            <div class="col">
                                <a href="#" class="btn w-100" data-bs-dismiss="modal">
                                    Thoát
                                </a>
                            </div>
                            <div class="col">

                                <button type="submit" class="btn btn-danger w-100">
                                    Huỷ đơn hàng
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
