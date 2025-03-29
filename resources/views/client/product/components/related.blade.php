<div class="container mb-30px">
    <div class="card border-0">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center gap-2 mb-5">
                <img src="{{ asset('images/icon-title.svg') }}" alt="">
                <h1 class="d-inline-block mb-0 text-primary fs-1">Sản phẩm liên quan</h1>
                <img src="{{ asset('images/icon-title.svg') }}" alt="">
            </div>

            <div class="row">
                @forelse ($relatedProducts as $product)
                    <div class="col-6 col-md-3 pb-2 pb-md-3">
                        <div class="card rounded-2">
                            <div class="card-body">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <img src="{{ asset($product->image) }}" alt=""
                                        class="w-100 h-100 rounded-xl" style="max-height: 250px;">
                                </a>
                                <p class="text-left fw-bold text-primary fs-3 mt-2">
                                    {{ $product->brand->name }}
                                </p>

                                <a href="{{ route('product.show', $product->slug) }}" class="nav-link p-0 text-dark">
                                    {{ limit_text($product->name, 70) }} </a>

                                @if ($product->sale_price && $product->sale_price > 0)
                                    <div class="d-flex align-items-center gap-2">
                                        <p class="text-left fs-2 fw-bold text-danger">
                                            {{ format_price($product->sale_price) }}
                                        </p>
                                        <p class="text-left fs-4 text-secondary">
                                            <del>{{ format_price($product->price) }}</del>
                                        </p>
                                    </div>
                                @else
                                    <p class="text-left fs-3 fw-bold text-danger">
                                        {{ format_price($product->price) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center fs-3">Không có sản phẩm liên quan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
