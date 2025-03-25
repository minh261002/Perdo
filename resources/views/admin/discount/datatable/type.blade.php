<span @class([
    'badge',
    App\Enums\Discount\DiscountType::from($type)->badge(),
])>{{ \App\Enums\Discount\DiscountType::getDescription($type) }}</span>
