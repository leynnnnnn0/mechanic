<?php

namespace App\Filament\Resources\AppointmentResource\Widgets;

use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppointmentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Appointments', Appointment::query()->where('status', 'pending')->count()),
            Stat::make('Cancelled', Appointment::query()->where('status', 'cancelled')->count()),
        ];
    }
}
