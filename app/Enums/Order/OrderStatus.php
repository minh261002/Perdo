<?php

namespace App\Enums\Order;

use App\Supports\Enum;

enum OrderStatus: string
{
    use Enum;

    case Pending = 'pending';

    case Processing = 'processing';

    case Completed = 'completed';

    case Cancelled = 'cancelled';

    public function badge(): string
    {
        return match ($this) {
            OrderStatus::Pending => 'bg-blue text-blue-fg',
            OrderStatus::Processing => 'bg-orange text-orange-fg',
            OrderStatus::Completed => 'bg-green text-green-fg',
            OrderStatus::Cancelled => 'bg-red text-red-fg',
        };
    }
}
