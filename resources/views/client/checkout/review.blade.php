@extends('client.layout.master')

@section('title', 'Xác nhận đơn hàng')

@section('content')
    <div class="container my-30px">
        <div class="card border-0 mb-5">
            <div class="card-body">
                <ul class="steps steps-primary steps-counter py-2">
                    <li class="step-item">Giỏ hàng</li>
                    <li class="step-item">Thanh toán</li>
                    <li class="step-item">Hoàn thành</li>
                </ul>
            </div>
        </div>

        <div class="card border-0 mb-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2 class="text-primary">Đơn hàng {{ $order->order_code }}</h2>
                </div>

                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Họ tên:</strong> {{ $order->name }}</p>
                            <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                            <p><strong>Email:</strong> {{ $order->email }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Phương thức thanh toán:</strong>
                                {{ \App\Enums\Transaction\PaymentMethod::getDescription($order->transaction->payment_method->value) }}
                            </p>
                            <p><strong>Trạng thái thanh toán</strong>
                                <span
                                    @class([
                                        'badge',
                                        App\Enums\Transaction\PaymentStatus::from(
                                            $order->transaction->payment_status->value)->badge(),
                                    ])>{{ \App\Enums\Transaction\PaymentStatus::getDescription($order->transaction->payment_status->value) }}</span>
                            </p>
                            <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có ghi chú' }}</p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                    <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td><strong>{{ number_format($order->total, 0, ',', '.') }}₫</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary">Trang chủ</a>
                    <a href="{{ route('profile.order.detail', $order->order_code) }}" class="btn btn-success ms-2">Xem chi
                        tiết đơn hàng</a>
                </div>
            </div>
        </div>
    </div>
@endsection
