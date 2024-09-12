<?php

namespace App\Enum;

enum Service : String
{
    case OIL_CHANGE = 'Oil Change';
    case BRAKE_REPAIR = 'Brake Repair';
    case TIRE_ROTATION = 'Tire Rotation';
    case WHEEL_ALIGNMENT = 'Wheel Alignment';
    case BATTERY_REPLACEMENT = 'Battery Replacement';
    case ENGINE_DIAGNOSTICS = 'Engine Diagnostics';
    case TRANSMISSION_REPAIR = 'Transmission Repair';
    case OTHERS = 'Others';
}
