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
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nhập mã giảm giá" name="discount_code"
                        id="discount_code">
                    <button class="btn btn-primary" type="button" id="apply_discount">
                        <i class="ti ti-brand-apple-arcade fs-2"></i>
                    </button>
                </div>
            @else
                <a href="{{ route('login', ['redirect' => route('checkout.index')]) }}" class="">Đăng nhập để dùng
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
            <input type="hidden" name="order[discount]" value="0">
            <input type="hidden" name="order[shipping_fee]" value="0">
            <input type="hidden" name="discount_id">
            <input type="hidden" name="order[subtotal]" value="{{ $subTotal }}">
            <input type="hidden" name="order[total]" value="{{ $totalPrice }}">
        </div>

        <hr class="border-dashed mb-4 border-dark" />

        <div class="d-flex flex-column">
            <div class="d-flex flex-column gap-2">
                <label class="d-block">
                    <input type="radio" name="transaction[payment_method]" value="cash_on_delivery" hidden checked />
                    <div class="d-flex align-items-center justify-content-between p-2 check-payment-method">
                        <span class="small fw-medium">Thanh toán khi nhận hàng</span>
                        <img src="{{ asset('images/cod.svg') }}" width="60" height="60" alt="icon"
                            class="img-fluid object-cover" />
                    </div>
                </label>

                <label class="d-block">
                    <input type="radio" name="transaction[payment_method]" value="qrcode" hidden />
                    <div class="d-flex align-items-center justify-content-between p-2 check-payment-method">
                        <span class="small fw-medium">Thanh toán qua QRCode</span>
                        <img src="{{ asset('images/vietqr.png') }}" width="60" height="60" alt="icon"
                            class="img-fluid object-cover" />
                    </div>
                </label>

                <label class="d-block">
                    <input type="radio" name="transaction[payment_method]" value="vnpay" hidden />
                    <div class="d-flex align-items-center justify-content-between p-2 check-payment-method">
                        <span class="small fw-medium">Cổng thanh toán VNPAY</span>
                        <img src="{{ asset('images/vnpay.webp') }}" width="60" height="60" alt="icon"
                            class="img-fluid object-cover" />
                    </div>
                </label>

                <label class="d-block">
                    <input type="radio" name="transaction[payment_method]" value="momo" hidden />
                    <div class="d-flex align-items-center justify-content-between p-2 check-payment-method">
                        <span class="small fw-medium">Cổng thanh toán Momo</span>
                        <img src="{{ asset('images/momo.svg') }}" width="60" height="60" alt="icon"
                            class="img-fluid object-cover" />
                    </div>
                </label>
            </div>
        </div>

        <hr class="border-dashed mb-4 border-dark" />

        <div class="d-flex justify-content-between align-items-center fs-4 fw-bold text-primary mb-4">
            <span>Tổng thanh toán</span>
            <span id="total">{{ format_price($totalPrice) }}</span>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Thanh toán
        </button>
    </div>
</div>
