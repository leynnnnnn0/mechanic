<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel
{
    case AWAITING_PAYMENT = 'Awaiting Payment';
    case PARTIALLY_PAID = 'Partially Paid';
    case REFUNDED = 'Refunded';
    case PAID = 'Paid';

    public static function getPaymentStatus()
    {
        $data = array_map(fn($case) => $case->value, self::cases());
        return array_combine($data, $data);
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
