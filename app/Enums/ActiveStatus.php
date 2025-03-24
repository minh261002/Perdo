<?php

namespace App\Enums;

use App\Supports\Enum;

enum ActiveStatus: string
{
    use Enum;

    case Active = 'active';

    case InActive = 'inActive';


    public function badge(): string
    {
        return match ($this) {
            ActiveStatus::Active => 'bg-green text-green-fg',
            ActiveStatus::InActive => 'bg-red text-red-fg',
        };
    }
}
