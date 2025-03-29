{{-- {{ $query->transaction->payment_status }} --}}


<span
    @class([
        'badge',
        App\Enums\Transaction\PaymentStatus::from(
            $query->transaction->payment_status->value)->badge(),
    ])>{{ \App\Enums\Transaction\PaymentStatus::getDescription($query->transaction->payment_status->value) }}</span>
