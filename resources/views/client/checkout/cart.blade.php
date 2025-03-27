@extends('client.layout.master')
@section('title', 'Giỏ hàng')

@section('content')
    <div class="container-xl my-30px">
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
                    <div class="col-md-8 pe-5">
                        @include('client.checkout.components.cart-table')
                    </div>
                    <div class="ps-5 col-md-4">
                        @include('client.checkout.components.cart-summary')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
