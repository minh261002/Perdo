<div class="card mb-3">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        <tr data-row-id="{{ $item['id'] }}">
                            <td style="width: 100px;">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid"
                                    width="100px">
                            </td>
                            <td>
                                <p class="text-primary fs-4 fw-bold">{{ $item['name'] }}</p>
                                {{ format_price($item['price']) }}
                            </td>
                            <td style="width: 180px;">
                                {{ $item['quantity'] }}
                            </td>
                            <td id="tbl-subtotal">
                                {{ format_price($item['price'] * $item['quantity']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('cart.index') }}" class="btn btn-primary mt-2" id="clearCart">Chỉnh sửa giỏ hàng</a>
    </div>
</div>

@push('scripts')
    <script>
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

        $('#removeItem').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('cart.remove') }}",
                method: 'DELETE',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $('#removeItem').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>.'
                    );
                },
                success: function(response) {
                    $('#total').html(format_price(response.totalPrice))
                    $('#subTotal').html(format_price(response.subTotal))
                    $('#tbl-subtotal').html(format_price(response.subTotal))
                    $('tr[data-row-id="' + id + '"]').remove();

                    if (response.cartCount == 0) {
                        location.reload();
                    }
                },
                error(err) {
                    console.log(err)
                },
                complete: function() {
                    $('#removeItem').html('<i class="ti ti-trash"></i>');
                }
            });
        })
    </script>
@endpush
