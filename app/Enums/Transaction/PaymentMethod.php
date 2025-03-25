<?php

namespace App\Enums\Transaction;

use App\Supports\Enum;

enum PaymentMethod: string
{
    use Enum;

    case COD = 'cash_on_delivery';

    case QRCODE = 'qrcode';

    case VNPAY = 'vnpay';

    case MOMO = 'momo';

    public function badge(): string
    {
        return match ($this) {
            PaymentMethod::COD => 'bg-green text-green-fg',
            PaymentMethod::QRCODE => 'bg-blue text-blue-fg',
            PaymentMethod::VNPAY => 'bg-orange text-orange-fg',
            PaymentMethod::MOMO => 'bg-yellow text-yellow-fg',
        };
    }
}