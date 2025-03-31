<div class="d-flex flex-column gap-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">
                    Trang chủ
                </a>
            </li>

            @foreach ($product->categories as $item)
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.admin.index') }}">
                        {{ $item->name }}
                    </a>
                </li>
            @endforeach
        </ol>
    </nav>

    <div>
        <h1 class="text-dark fs-1 mb-1">{{ $product->name }}</h1>

        <span class="text-secondary fs-3">
            SKU: {{ $product->sku }}
        </span>
    </div>

    <div class="d-flex align-items-center gap-3">
        <span class="gl-star-rating--stars" data-rating="5">
            <span data-index="0" data-value="1">
                <i class="ti ti-star-filled fs-1 text-warning"></i>
            </span>
            <span data-index="1" data-value="2">
                <i class="ti ti-star-filled fs-1 text-warning"></i>
            </span>
            <span data-index="2" data-value="3">
                <i class="ti ti-star-filled fs-1 text-warning"></i>
            </span>
            <span data-index="3" data-value="4">
                <i class="ti ti-star-filled fs-1 text-warning"></i>
            </span>
            <span data-index="4" data-value="5">
                <i class="ti ti-star-filled fs-1 text-warning"></i>
            </span>
        </span>

        <span class="text-secondary fs-4">
            (100 đánh giá)
        </span>
    </div>

    <div class="d-flex align-items-center gap-3">
        @if ($product->sale_price && $product->sale_price > 0)
            <p class="text-danger fs-1 fw-bold" style="font-size: 30px !important;">
                {{ format_price($product->sale_price) }}
            </p>
            <p class="text-secondary fs-4">
                <del>{{ format_price($product->price) }}</del>
            </p>
        @else
            <p class="text-danger fs-1 fw-bold">
                {{ format_price($product->price) }}
            </p>
        @endif
    </div>

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <label for="stock" class="form-label">Số lượng</label>
            <div class="input-group" style="max-width: 200px;">
                <button class="btn btn-primary" type="button" id="button-minus">-</button>
                <input type="text" class="form-control text-center" value="1"
                    aria-label="Example text with button addon" aria-describedby="button-addon1" name="stock"
                    data-stock="{{ $product->stock }}">
                <button class="btn btn-primary" type="button" id="button-plus">+</button>
            </div>
            <div>
                <span class="text-danger" id="stock-error"></span>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between gap-2">
            <span class="d-flex align-items-center justify-content-between gap-2 fs-3 text-primary">
                <i class="ti ti-building-warehouse "></i>
                Kho hàng:
            </span>

            Còn <strong>{{ $product->stock }}</strong> sản phẩm
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6 mb-3">

            @if (auth()->guard('web')->user() && auth()->guard('web')->user()->wishlists->contains($product->id))
                <button class="btn btn-danger w-100 removeWishlist" data-product-id="{{ $product->id }}">
                    <i class="ti ti-heart me-2 fs-1"></i>
                    <span class="fs-3">Đã thích</span>
                </button>
            @else
                <button class="btn btn-outline-danger w-100 addToWishlist" data-product-id="{{ $product->id }}">
                    <i class="ti ti-heart me-2 fs-1"></i>
                    <span class="fs-3">
                        Thêm vào danh sách yêu thích
                    </span>
                </button>
            @endif
        </div>

        <div class="col-md-6 mb-3">
            <button class="btn btn-primary w-100" id="addToCart">
                <i class="ti ti-shopping-cart me-2 fs-1"></i>
                <span class="fs-3">Thêm vào giỏ hàng</span>
            </button>
        </div>
    </div>

    @include('client.product.components.brand')
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let stock = $('input[name="stock"]').data('stock');
            $('#button-plus').click(function() {
                var value = parseInt($('input[name="stock"]').val());
                $('input[name="stock"]').val(value + 1);
                if (value >= stock) {
                    $('input[name="stock"]').val(stock);
                    $('#stock-error').text('Số lượng sản phẩm trong kho không đủ.');
                }
            });

            $('#button-minus').click(function() {
                var value = parseInt($('input[name="stock"]').val());
                if (value > 1) {
                    $('input[name="stock"]').val(value - 1);
                }
                if (stock != '') {
                    $('#stock-error').text('');
                }
            });

            $('#toggleBtn').click(function() {
                $('#content').toggleClass('hidden-content');
                if ($('#content').hasClass('hidden-content')) {
                    $('#toggleBtn').text('Xem thêm');
                } else {
                    $('#toggleBtn').text('Thu gọn');
                }
            });

            $(document).on('click', '.addToWishlist', function(e) {
                e.preventDefault();
                let productId = $(this).data('product-id');
                let button = $(this);

                button.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-md" role="status"></span> '
                );

                $.ajax({
                    url: "{{ route('wishlist.store') }}",
                    method: 'POST',
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            FuiToast.success(response.message);
                            button.replaceWith(`
                    <button class="btn btn-danger w-100 removeWishlist" data-product-id="${productId}">
                        <i class="ti ti-heart me-2 fs-1"></i>
                        <span class="fs-3">Đã thích</span>
                    </button>
                `);
                        } else {
                            FuiToast.error(response.message);
                        }
                    },
                    error: function(err) {
                        FuiToast.error(err.responseJSON.message);
                    },
                    complete: function() {
                        button.prop('disabled', false).html(
                            '<i class="ti ti-heart me-2 fs-1"></i><span class="fs-3">Thêm vào danh sách yêu thích</span>'
                        );
                    }
                });
            });

            $(document).on('click', '.removeWishlist', function(e) {
                e.preventDefault();
                let productId = $(this).data('product-id');
                let button = $(this);

                button.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-md" role="status"></span> '
                );

                $.ajax({
                    url: "{{ route('wishlist.delete') }}",
                    method: 'DELETE',
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            FuiToast.success(response.message);
                            button.replaceWith(`
                    <button class="btn btn-outline-danger w-100 addToWishlist" data-product-id="${productId}">
                        <i class="ti ti-heart me-2 fs-1"></i>
                        <span class="fs-3">Thêm vào danh sách yêu thích</span>
                    </button>
                `);
                        } else {
                            FuiToast.error(response.message);
                        }
                    },
                    error: function(err) {
                        FuiToast.error(err.responseJSON.message);
                    },
                    complete: function() {
                        button.prop('disabled', false).html(
                            '<i class="ti ti-heart me-2 fs-1"></i><span class="fs-3">Đã thích</span>'
                        );
                    }
                });
            });

        });
    </script>
@endpush
