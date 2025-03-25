<?php

namespace App\Enums\Transaction;

use App\Supports\Enum;

enum PaymentStatus: string
{
    use Enum;

    case Pending = 'pending';

    case Completed = 'completed';

    case Cancelled = 'cancelled';

    public function badge(): string
    {
        return match ($this) {
            PaymentStatus::Pending => 'bg-blue text-blue-fg',
            PaymentStatus::Completed => 'bg-green text-green-fg',
            PaymentStatus::Cancelled => 'bg-red text-red-fg',
        };
    }
}