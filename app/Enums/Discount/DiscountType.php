<?php

namespace App\Enums\Discount;

use App\Supports\Enum;

enum DiscountType: int
{
    use Enum;

    case Percentage = 1;
    case Fixed = 2;

    public function badge(): string
    {
        return match ($this) {
            DiscountType::Percentage => 'bg-green text-green-fg',
            DiscountType::Fixed => 'bg-red text-red-fg',
        };
    }
}
