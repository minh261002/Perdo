<div class="card">
    <div class="card-header">
        <h1 class="mb-0 card-title">Giỏ hàng</h1>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped w-100" style="overflow-x:auto;">
                <thead>
                    <tr>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Tổng</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td style="width: 100px;">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid"
                                    width="100px">
                            </td>
                            <td style="width: 350px;">
                                <p class="text-primary fs-4 fw-bold">{{ $item['name'] }}</p>
                                {{ format_price($item['price']) }}
                            </td>
                            <td style="width: 180px;">
                                <div class="input-group">
                                    <button class="btn btn-primary" type="button" id="button-minus">-</button>
                                    <input type="text" class="form-control text-center"
                                        value="{{ $item['quantity'] }}" aria-label="Example text with button addon"
                                        aria-describedby="button-addon1" name="stock"
                                        data-stock="{{ $item['stock'] }}" data-id="{{ $item['id'] }}">
                                    <button class="btn btn-primary" type="button" id="button-plus">+</button>
                                </div>
                            </td>
                            <td id="tbl-subtotal">
                                {{ format_price($item['price'] * $item['quantity']) }}
                            </td>
                            <td>
                                <button class="btn btn-danger" data-id="{{ $item['id'] }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('cart.refresh') }}" class="btn btn-danger" id="clearCart">Xoá giỏ hàng</a>
    </div>
</div>

@push('scripts')
    <script>
        //cập nhật số lượng sản phẩm
        $(document).on('click', '#button-minus', function() {
            var input = $(this).parent().find('input');
            var id = input.data('id');
            var stock = input.data('stock');
            var quantity = parseInt(input.val());
            if (quantity > 1) {
                quantity -= 1;
                input.val(quantity);
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: 'PUT',
                    data: {
                        id: id,
                        quantity: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#total').html(format_price(response.totalPrice))
                        $('#subTotal').html(format_price(response.subTotal))
                        $('#tbl-subtotal').html(format_price(response.subTotal))
                    },
                    error(err) {
                        console.log(err)
                    }
                });
            }
        });

        $(document).on('click', '#button-plus', function() {
            var input = $(this).parent().find('input');
            var id = input.data('id');
            var stock = input.data('stock');
            var quantity = parseInt(input.val());
            if (quantity < stock) {
                quantity += 1;
                input.val(quantity);
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: 'PUT',
                    data: {
                        id: id,
                        quantity: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#total').html(format_price(response.totalPrice))
                        $('#subTotal').html(format_price(response.subTotal))
                        $('#tbl-subtotal').html(format_price(response.subTotal))
                    }
                });
            }
        });
    </script>
@endpush
