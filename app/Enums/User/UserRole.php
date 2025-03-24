<?php

namespace App\Enums\User;

use App\Supports\Enum;

enum UserRole: string
{
    use Enum;

    case Guest = 'guest';

    case Host = 'host';

    public function badge(): string
    {
        return match ($this) {
            UserRole::Guest => 'bg-green text-green-fg',
            UserRole::Host => 'bg-red text-red-fg',
        };
    }
}