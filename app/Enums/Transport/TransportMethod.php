<?php

namespace App\Enums\Transport;

use App\Supports\Enum;

enum TransportMethod: string
{
    use Enum;

    case GHTK = 'ghtk';

    public function badge(): string
    {
        return match ($this) {
            TransportMethod::GHTK => 'bg-blue text-blue-fg',
        };
    }
}
