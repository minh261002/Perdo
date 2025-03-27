@extends('client.layout.master')

@section('title', 'Cửa hàng dành cho mẹ & bé trên toàn quốc')

@section('content')
    @include('client.home.components.carousel')
    @include('client.home.components.brand')
    @include('client.home.components.discount')
    @include('client.home.components.newProduct')
@endsection
