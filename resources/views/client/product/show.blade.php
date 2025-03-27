@extends('client.layout.master')

@section('title', $product->meta_title ?? $product->name)

@section('content')
    <div class="container my-30px d-flex flex-column gap-5">
        <div class="card border-0">
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

        <div class="card border-0">
            <div class="card-body">
                @include('client.product.components.related')
            </div>
        </div>

        <div class="card border-0">
            <div class="card-body">
                @include('components.viewed')
            </div>
        </div>
    </div>
@endsection
