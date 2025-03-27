@extends('client.layout.master')

@section('title', $product->meta_title ?? $product->name)

@section('content')
    <div class="container my-30px">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 pe-5">
                        @include('client.product.components.gallery')
                    </div>
                    <div class="col-md-6 ps-5">
                        @include('client.product.components.info')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
