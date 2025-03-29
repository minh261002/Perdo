<span
    @class([
        'badge',
        App\Enums\Order\OrderStatus::from(
            $query->statuses()->latest()->first()->status->value)->badge(),
    ])>{{ \App\Enums\Order\OrderStatus::getDescription($query->statuses()->latest()->first()->status->value) }}</span>
