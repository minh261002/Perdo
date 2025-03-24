<?php

namespace App\Enums\Module;

use App\Supports\Enum;

enum ModuleStatus: string
{
    use Enum;

    case InProgress = 'in_progress';

    case Completed = 'completed';


    public function badge(): string
    {
        return match ($this) {
            ModuleStatus::Completed => 'bg-green text-green-fg',
            ModuleStatus::InProgress => 'bg-red text-red-fg',
        };
    }
}
