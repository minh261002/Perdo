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

    <div>
        <label for="stock" class="form-label">Số lượng</label>
        <div class="input-group w-25">
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

    <div>
        <button class="btn btn-primary w-25">
            Thêm vào giỏ hàng
        </button>
    </div>

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
        });
    </script>
@endpush
