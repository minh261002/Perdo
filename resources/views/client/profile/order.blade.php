@extends('client.layout.master')

@section('title', 'Đơn hàng')

@section('content')
    <div class="my-30px">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    @include('client.profile.components.left-side')

                    <div class="col-12 col-md-10 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-4">Danh sách đơn hàng</h2>
                            <div id="table-default" class="table-responsive">
                                <div class="mb-3">
                                    <div class="btn-group w-25 mb-3">
                                        <button type="button" class="btn btn-3 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            {{ request()->get('status') ? \App\Enums\Order\OrderStatus::getDescription(request()->get('status')) : 'Tất cả' }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('profile.orders') }}">Tất cả</a>
                                            </li>
                                            @foreach (\App\Enums\Order\OrderStatus::asSelectArray() as $key => $value)
                                                <li>
                                                    <a class="dropdown-item {{ request()->get('status') == $key ? 'active' : '' }}"
                                                        href="{{ route('profile.orders', ['status' => $key]) }}">{{ $value }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <button class="table-sort" data-sort="sort-name">
                                                    Mã đơn hàng
                                                </button>
                                            </th>

                                            <th>
                                                <button class="table-sort" data-sort="sort-name">
                                                    Tổng tiền
                                                </button>
                                            </th>

                                            <th>
                                                <button class="table-sort" data-sort="sort-name">
                                                    Trạng thái
                                                </button>
                                            </th>

                                            <th>
                                                <button class="table-sort" data-sort="sort-name">
                                                    Ngày tạo
                                                </button>
                                            </th>

                                            <th>
                                                <button class="table-sort" data-sort="sort-name">
                                                    Hành động
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ number_format($order->total) }}đ</td>
                                                <td>
                                                    <span
                                                        @class([
                                                            'badge',
                                                            \App\Enums\Order\OrderStatus::from(
                                                                $order->statuses()->latest()->first()->status->value)->badge(),
                                                        ])>{{ \App\Enums\Order\OrderStatus::getDescription($order->statuses()->latest()->first()->status->value) }}</span>

                                                </td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('profile.order.detail', $order->id) }}"
                                                        class="btn btn-3">Xem chi tiết</a>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <div class="d-flex justify-content-end">
                                                    {{ $orders->links('components.pagination') }}

                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
