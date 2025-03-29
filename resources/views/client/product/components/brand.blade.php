<div class="shop-banner shadow">
    <a href="{{ route('brand.index', $product->brand->slug) }}"> <img src="{{ $product->brand->logo }}" alt="Logo"
            class="rounded-circle bg-light logo-brand">
    </a>
    <div class="shop-info">
        <h4>
            <a href="{{ route('brand.index', $product->brand->slug) }}"
                class="text-decoration-none text-primary fs-1">{{ $product->brand->name }}</a>
        </h4>
        <span class="badge badge-custom">Chính Hãng</span>
    </div>
    <div class="">
        <ul class="list-unstyled mb-0">
            <li class="fs-3 fw-bold text-primary">
                <i class="ti ti-check me-1"></i>
                100% chất lượng
            </li>
            <li class="fs-3 fw-bold text-primary"> <i class="ti ti-check me-1"></i>
                Phân phối chính hãng</li>
            <li class="fs-3  fw-bold text-primary"> <i class="ti ti-check me-1"></i>
                Đổi trả dễ dàng</li>
        </ul>
    </div>
</div>

<div class="d-block d-md-flex align-items-center justify-content-between mt-5">
    <div class="d-flex w-100 flex-column gap-2 align-items-center justify-content-center">
        <img src="{{ asset('images/back.png') }}" class="me-2 icon-img" alt="back">
        <span class="text-center">Đổi trả sản phẩm miễn phí trong 30 ngày </span>
    </div>

    <div class="d-flex w-100 flex-column gap-2 align-items-center justify-content-center">
        <img src="{{ asset('images/cash.png') }}" class="me-2 icon-img" alt="back">
        <span class="text-center">Hỗ trợ nhiều hình thức thanh toán</span>
    </div>

    <div class="d-flex w-100 flex-column gap-2 align-items-center justify-content-center">
        <img src="{{ asset('images/delivery.png') }}" class="me-2 icon-img" alt="back">
        <span class="text-center">Giao hàng miễn phí cho đơn hàng trên 500.000đ</span>
    </div>
</div>
