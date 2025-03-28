<div class="card">
    <div class="card-header">
        <h2 class="card-title text-left fw-bold">Thành tiền</h2>
    </div>

    <div class="card-body">
        <div class="mb-4">
            <label class="form-label fw-semibold mb-2">
                MÃ PHIẾU GIẢM GIÁ
            </label>
            @if (Auth::guard('web')->check())
                Bạn có thể sử dụng mã giảm giá ở bước tiếp theo
            @else
                <a href="{{ route('login', ['redirect' => route('cart.index')]) }}" class="">Đăng nhập để sử dụng
                    mã giảm giá</a>
            @endif
        </div>

        <hr class="border-dashed mb-4 border-dark" />

        <div class="space-y-3 mb-4">
            <div class="d-flex justify-content-between text-sm">
                <span class="text-muted">Tạm tính</span>
                <span class="fw-semibold" id="subTotal">{{ format_price($subTotal) }}</span>
            </div>
            <div class="d-flex justify-content-between text-sm">
                <span class="text-muted">Phí vận chuyển</span>
                <span class="fw-semibold" id="shipping_fee">0 ₫</span>
            </div>

            <div class="d-flex justify-content-between text-sm">
                <span class="text-muted">Mã giảm giá</span>
                <span class="fw-semibold text-primary" id="discount">-0 ₫</span>
            </div>
            <input type="hidden" name="discount_amount" value="0">
        </div>

        <hr class="border-dashed mb-4 border-dark" />

        <div class="d-flex justify-content-between align-items-center fs-4 fw-bold text-primary mb-4">
            <span>Tổng thanh toán</span>
            <span id="total">{{ format_price($totalPrice) }}</span>
        </div>

        <a href="{{ route('checkout.index') }}" type="submit" class="btn btn-primary w-100">
            Tiến hành thanh toán
        </a>
    </div>
</div>
