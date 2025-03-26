@extends('client.layout.master')

@section('title', 'Cửa hàng dành cho mẹ & bé trên toàn quốc')

@section('content')
    @include('client.layout.partials.navbar')


    @include('client.home.components.carousel')
    @include('client.home.components.brand')
    @include('client.home.components.discount')
@endsection
