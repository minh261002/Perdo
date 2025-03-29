<?php

namespace App\Enums\Notification;

use App\Supports\Enum;

enum NotificationObj: string
{
    use Enum;

    case All = 'all';
    case Admin = 'admin';
    case User = 'user';

    public function badge(): string
    {
        return match ($this) {
            NotificationObj::All => 'bg-blue text-blue-fg',
            NotificationObj::Admin => 'bg-yellow text-yellow-fg',
            NotificationObj::User => 'bg-green text-green-fg',
        };
    }
}