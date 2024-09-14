<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AppointmentStatus : string implements HasLabel, HasColor
{
    case CONFIRMED = 'confirmed';
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CONFIRMED => 'success',
            self::PENDING => 'warning',
            self::CANCELLED => 'danger',
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }


}
