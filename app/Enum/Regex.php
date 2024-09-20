<?php

namespace App\Enum;

enum Regex: string
{
    case PHONE_NUMBER = '/^09\d{9}$/';
    case EMAIL = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';
}
