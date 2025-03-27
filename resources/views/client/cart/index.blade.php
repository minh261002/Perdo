@extends('client.layout.master')
@section('title', 'Giỏ hàng')

@section('content')
    <div class="container my-30px">
        @if (!empty($cart))
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <ul class="steps steps-primary steps-counter py-2">
                        <li class="step-item active">Giỏ hàng</li>
                        <li class="step-item active">Thanh toán</li>
                        <li class="step-item">Hoàn thành</li>
                    </ul>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            @include('client.cart.components.cart-table')
                        </div>
                        <div class=" col-md-3">
                            @include('client.cart.components.cart-summary')
                        </div>
                    </div>
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
@endsection
