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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="h3">Đơn vị cung cấp</p>
                                        <address>
                                            Công ty TNHH giải pháp phần mềm Việt Nam Tiên Phong
                                            <br />
                                            Tầng 12, toà nhà Etown5, số 364 Cộng Hoà, Phường 13, Quận Tân Bình, TP. Hồ Chí
                                            Minh
                                            <br />
                                            Điện thoại: 0987654321 <br />
                                            Email: contact@nextarea.vn
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
                                    <a href="{{ route('admin.order.invoice.print', $order->id) }}"
                                        class="btn btn-primary d-print-none" id="printBtn">
                                        <i class="ti ti-file-type-pdf fs-1 me-2"></i>
                                        In hoá đơn
                                    </a>
                                </div>
                                <p class="text-secondary text-center mt-5">Thank you very much for doing business with us.
                                    We
                                    look forward to working with
                                    you again!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
