@extends('client.layout.master')

@section('title', $product->meta_title ?? $product->name)
@push('styles')
    <style>
        .product-description {
            width: 100% !important;
        }
    </style>
@endpush
@section('content')
    <div class="container my-30px d-flex flex-column gap-5">
        <div class="card border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 pe-0 pe-md-5">
                        @include('client.product.components.gallery')
                    </div>
                    <div class="col-md-6 ps-0 ps-md-5 pt-5 pt-md-0">
                        @include('client.product.components.info')
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-body">
                @include('client.product.components.tab')
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#addToCart').on('click', function(e) {
                e.preventDefault();

                let id = {{ $product->id }};
                let name = "{{ $product->name }}";
                let price =
                    "{{ $product->sale_price && $product->sale_price > 0 ? $product->sale_price : $product->price }}";
                let image = "{{ $product->image }}";
                let stock = "{{ $product->stock }}";
                let quantity = $('input[name="stock"]').val();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: 'POST',
                    data: {
                        id: id,
                        name: name,
                        price: price,
                        image: image,
                        stock: stock,
                        quantity: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#addToCart').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>.'
                        );
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            FuiToast.success(response.message);
                            $('#cart-count').text(response.cartCount);
                        } else {
                            FuiToast.error(response.message);
                        }
                    },
                    error: function(err) {
                        FuiToast.error(err.responseJSON.message);
                    },
                    complete: function() {
                        $('#addToCart').html(
                            '<i class="ti ti-shopping-cart me-2 fs-1"></i><span class="fs-3">Thêm vào giỏ hàng</span>'
                        );
                    }

                });
            })
        })
    </script>
@endpush
