@extends('client.layout.master')

@section('title', 'Danh sách yêu thích')

@section('content')
    <div class="my-30px">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    @include('client.profile.components.left-side')

                    <div class="col-12 col-md-10 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-4">Danh sách yêu thích</h2>

                            <div id="table-default" class="table-responsive">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <form action="{{ route('profile.wishlists') }}" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Nhập tên sản phẩm"
                                                name="q" value="{{ request()->get('q') }}">
                                            <button class="btn btn-3" type="submit" id="button-addon2">
                                                <i class="ti ti-search"></i>
                                            </button>
                                        </div>

                                    </form>
                                </div>

                                <table class="table h-100">
                                    <thead>
                                        <tr>
                                            <th>
                                                Sản phẩm
                                            </th>

                                            <th>
                                                Giá
                                            </th>
                                            <th>
                                                Ngày thêm
                                            </th>
                                            <th>
                                                Hành động
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($wishlists as $wishlist)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('product.show', $wishlist->slug) }}">
                                                        {{ $wishlist->name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($wishlist->sale_price && $wishlist->sale_price > 0)
                                                        <p class="text-danger fw-bold">
                                                            {{ format_price($wishlist->sale_price) }}
                                                        </p>
                                                        <p class="text-secondary fs-4">
                                                            <del>{{ format_price($wishlist->price) }}</del>
                                                        </p>
                                                    @else
                                                        <p class="text-danger fw-bold">
                                                            {{ format_price($wishlist->price) }}
                                                        </p>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $wishlist->created_at->format('d/m/Y H:i') }}
                                                </td>

                                                <td>
                                                    <button class="btn btn-danger removeWishlist"
                                                        data-product-id="{{ $wishlist->id }}">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.removeWishlist', function(e) {
            e.preventDefault();
            let productId = $(this).data('product-id');
            let button = $(this);

            button.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status"></span> '
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
                        button.closest('tr').remove();
                        if ($('tbody tr').length == 0) {
                            $('tbody').html(`
                                <tr>
                                    <td colspan="4" class="text-center">Không có dữ liệu</td>
                                </tr>
                            `);
                        }
                    } else {
                        FuiToast.error(response.message);
                    }
                },
                error: function(err) {
                    FuiToast.error(err.responseJSON.message);
                },
            });
        });
    </script>
@endpush
