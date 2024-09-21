<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AppointmentStatus: string implements HasLabel, HasColor
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case WORK_STARTED = 'work started';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CONFIRMED, self::COMPLETED => 'success',
            self::PENDING => 'warning',
            self::CANCELLED => 'danger',
            self::WORK_STARTED => 'primary',
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
