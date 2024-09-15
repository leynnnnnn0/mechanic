<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RepairStatus : string implements HasLabel
{
    case SCHEDULED = 'scheduled';
    case IN_PROGRESS = 'in_progress';
    case PAUSED = 'paused';
    case COMPLETED = 'completed';
    case READY_FOR_PICKUP = 'ready_for_pickup';
    case AWAITING_PAYMENT = 'awaiting_payment';
    case DONE = 'done';
    case CANCELLED = 'cancelled';


    public function getLabel(): ?string
    {
       return $this->name;
    }
}
