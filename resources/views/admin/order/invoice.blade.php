@extends('layouts.master')
@section('title', 'Đơn hàng ' . $order->order_code)

@push('styles')
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
                                <a href="{{ route('dashboard') }}">
                                    <i class="bi bi-house"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('order.index') }}">
                                    Quản lý đơn hàng
                                </a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                Đơn hàng {{ $order->order_code }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="page-body">
                <div class="card card-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h3">Công ty</p>
                                <address>
                                    Công ty cổ phần Litte Kids - CCI Group <br />
                                    Số 5B Cộng hoà, Phường 2, Quận Tân Bình, Hồ Chí Minh, Việt Nam <br />
                                    Điện thoại: 0987654321 <br />
                                    Email: cskh@littekids.vn
                                </address>
                            </div>
                            <div class="col-6 text-end">
                                <p class="h3">Khách hàng</p>
                                <address>
                                    {{ $order->name }} <br />
                                    {{ $order->phone }} <br />
                                    {{ $order->email }} <br />
                                    {{ $order->address }}
                                </address>
                            </div>
                            <div class="col-12 my-5">
                                <h1>Hoá đơn {{ $order->order_code }}</h1>
                            </div>
                        </div>
                        <table class="table table-transparent table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 1%"></th>
                                    <th>Sản phẩm</th>
                                    <th class="text-center" style="width: 1%">Số lượng</th>
                                    <th class="text-end" style="width: 10%">Giá</th>
                                    <th class="text-end" style="width: 10%">Tạm tính</th>
                                </tr>
                            </thead>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
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

                            <tr>
                                <td colspan="4" class="strong text-end">Tạm tính</td>
                                <td class="text-end">
                                    {{ format_price($order->subtotal) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="strong text-end">Giảm giá</td>
                                <td class="text-end">{{ format_price($order->discount) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="strong text-end">Phí vận chuyển</td>
                                <td class="text-end">
                                    {{ format_price($order->shipping_fee) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="font-weight-bold text-uppercase text-end">Tổng tiền</td>
                                <td class="font-weight-bold text-end">
                                    {{ format_price($order->total) }}
                                </td>
                            </tr>
                        </table>

                        <div class="w-100 text-end">
                            <a href="{{ route('order.invoice.print', $order->id) }}" class="btn btn-primary d-print-none"
                                id="printBtn">
                                <i class="ti ti-file-type-pdf fs-1 me-2"></i>
                                In hoá đơn
                            </a>
                        </div>
                        <p class="text-secondary text-center mt-5">Thank you very much for doing business with us. We
                            look forward to working with
                            you again!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#printBtn').on('click', function(e) {
                e.preventDefault();
                const printUrl = $(this).attr('href');

                $(this).html('<i class="ti ti-printer fs-1 me-2"></i> Đang in hoá đơn...');

                setTimeout(() => {
                    window.location.href = printUrl;
                    $(this).html('<i class="ti ti-file-type-pdf fs-1 me-2"></i> In hoá đơn');
                }, 2000);

            });
        });
    </script>
@endpush
