@switch($payment_method)
    @case(\App\Enums\Transaction\PaymentMethod::COD->value)
        <img src="{{ asset('images/cod.svg') }}" style="width: 80px" />
    @break

    @case(\App\Enums\Transaction\PaymentMethod::VNPAY->value)
        <img src="{{ asset('images/vnpay.webp') }}" style="width: 80px" />
    @break

    @case(\App\Enums\Transaction\PaymentMethod::MOMO->value)
        <img src="{{ asset('images/momo.svg') }}" style="width: 80px" />
    @break

    @case(\App\Enums\Transaction\PaymentMethod::QRCODE->value)
        <img src="{{ asset('images/vietqr.png') }}" style="width: 80px" />
    @break

    @default
    @break
@endswitch
