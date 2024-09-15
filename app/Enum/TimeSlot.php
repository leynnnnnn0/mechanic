<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum TimeSlot : string implements HasLabel
{
    case SLOT1= '8:00 am - 9:00 am';
    case SLOT2 = '9:00 am - 10:00 am';
    case SLOT3 = '10:00 am - 11:00 am';
    case SLOT4 = '11:00 am - 12:00 pm';
    case SLOT5 = '1:00 pm - 2:00 pm';
    case SLOT6 = '2:00 pm - 3:00 pm';
    case SLOT7 = '3:00 pm - 4:00 pm';
    case SLOT8 = '4:00 pm - 5:00 pm';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
