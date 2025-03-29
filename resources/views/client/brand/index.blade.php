@extends('client.layout.master')

@section('title', 'Thương hiệu ' . $brand->name ?? 'Thương hiệu')

@section('content')
    <div class="container my-30px">
        <div class="card">
            <div class="card-body">
                @include('client.brand.components.info')
            </div>

            <div class="card-body">
                {{-- @include('components.filter')

                @include('client.brand.components.product') --}}
                <div class="row">
                    <div class="col-md-3">
                        @include('components.filter')

                    </div>

                    <div class="col-md-9">
                        @include('client.brand.components.product')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
