<?php

namespace App\Enums\Notification;

use App\Supports\Enum;

enum NotificationType: string
{
    use Enum;

    case One = 'one';
    case All = 'all';

    public function badge(): string
    {
        return match ($this) {
            NotificationType::One => 'bg-yellow text-yellow-fg',
            NotificationType::All => 'bg-green text-green-fg',
        };
    }
}
