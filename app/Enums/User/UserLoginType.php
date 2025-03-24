<?php

namespace App\Enums\User;

use App\Supports\Enum;

enum UserLoginType: string
{
    use Enum;

    case Email = 'email';
    case Google = 'google';
    case Facebook = 'facebook';

    public function badge(): string
    {
        return match ($this) {
            UserLoginType::Email => 'bg-green text-green-fg',
            UserLoginType::Google => 'bg-red text-red-fg',
            UserLoginType::Facebook => 'bg-blue text-blue-fg',
        };
    }
}
