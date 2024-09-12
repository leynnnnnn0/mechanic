<?php

namespace App\Enum;

enum Role: string
{
    case ADMIN = 'admin';
    case MECHANIC = 'mechanic';
    case CUSTOMER = 'customer';
}
