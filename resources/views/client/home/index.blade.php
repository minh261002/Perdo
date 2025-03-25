@extends('client.layout.master')

@section('title', 'Larana, Inc - Trang chủ')

@section('content')
    @include('client.layout.partials.navbar')


    <div class="container">
        <div class="my-5">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-info">
                        This is a demo project for educational purpose. It is not a real company.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
