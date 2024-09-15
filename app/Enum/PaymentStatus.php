<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus : string implements HasLabel
{
    case AWAITING_PAYMENT = 'awaiting_payment';
    case PARTIALLY_PAID = 'partially_paid';
    case REFUNDED = 'refunded';
    case PAID = 'paid';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
