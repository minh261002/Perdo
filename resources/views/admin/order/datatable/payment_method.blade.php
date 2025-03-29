{{-- {{ $query->transaction->payment_method }} --}}

@switch($query->transaction->payment_method)
    @case(\App\Enums\Transaction\PaymentMethod::COD)
        <img src="{{ asset('images/cod.svg') }}" alt="COD" class="img-fluid" width="80">
    @break

    @case(\App\Enums\Transaction\PaymentMethod::VNPAY)
        <img src="{{ asset('images/vnpay.webp') }}" alt="Paypal" class="img-fluid" width="80">
    @break

    @case(\App\Enums\Transaction\PaymentMethod::MOMO)
        <img src="{{ asset('images/momo.svg') }}" alt="Stripe" class="img-fluid" width="80">
    @break

    @case(\App\Enums\Transaction\PaymentMethod::QRCODE)
        <img src="{{ asset('images/vietqr.png') }}" alt="Razorpay" class="img-fluid" width="80">
    @break

    @default
@endswitch
