<span @class([
    'badge',
    App\Enums\Transaction\PaymentStatus::from($payment_status)->badge(),
])>{{ \App\Enums\Transaction\PaymentStatus::getDescription($payment_status) }}</span>
