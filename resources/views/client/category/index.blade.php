@extends('client.layout.master')

@section('title', $category->name ?? 'Danh mục sản phẩm')

@section('content')
    <div class="container my-30px">
        <div class="card">
            <div class="card-body">
                @include('client.category.components.brand')
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        @include('components.filter')

                    </div>

                    <div class="col-md-9">
                        @include('client.category.components.product')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
