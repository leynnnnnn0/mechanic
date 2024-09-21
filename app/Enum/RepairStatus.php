<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RepairStatus: string implements HasLabel
{
    case CANCELLED = 'cancelled';
    case PAUSED = 'paused';
    case SCHEDULED = 'scheduled';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case READY_FOR_PICKUP = 'ready_for_pickup';
    case DONE = 'done';


    public function getLabel(): ?string
    {
        return $this->name;
    }
}
