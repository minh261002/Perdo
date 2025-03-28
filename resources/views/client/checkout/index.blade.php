@extends('client.layout.master')
@section('title', 'Thanh toán đơn hàng')

@section('content')
    <div class="container my-30px">
        @if (!empty($cart))
            <div class="card border-0 mb-5">
                <div class="card-body">
                    <ul class="steps steps-primary steps-counter py-2">
                        <li class="step-item ">Giỏ hàng</li>
                        <li class="step-item active">Thanh toán</li>
                        <li class="step-item active">Hoàn thành</li>
                    </ul>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <form class="row">
                        <div class="col-md-9">
                            @include('client.checkout.components.user-info')
                            @include('client.checkout.components.cart-table')
                        </div>
                        <div class=" col-md-3">
                            @include('client.checkout.components.cart-summary')
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center justify-content-center gap-3 py-5">
                        <img src="{{ asset('images/empty.webp') }}" alt="" class="img-fluid w-50">

                        <div class="text-center">
                            <h2 class="fw-bold mb-2">Giỏ hàng trống</h2>
                            <p class="text-secondary mb-2">Không có sản phẩm nào trong giỏ hàng của bạn</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @include('components.modal-pick-address')
    @include('components.google-map-script')
@endsection
