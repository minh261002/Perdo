<?php

namespace App\Enums\Discount;

use App\Supports\Enum;

enum DiscountApplyFor: int
{
    use Enum;

    case All = 2;
    case One = 1;

    public function badge(): string
    {
        return match ($this) {
            DiscountApplyFor::One => 'bg-green text-green-fg',
            DiscountApplyFor::All => 'bg-red text-red-fg',
        };
    }
}