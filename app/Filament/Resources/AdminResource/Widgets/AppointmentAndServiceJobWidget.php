<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use App\Models\Appointment;
use App\Models\ServiceJob;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppointmentAndServiceJobWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $counts = ServiceJob::query()
            ->selectRaw('status, count(*) as count')
            ->whereIn('status', ['completed', 'ready_for_pick_up'])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        return [
            Stat::make('Pending Appointments', Appointment::where('status', 'pending')->count()),
            Stat::make('Completed Service Jobs', $counts['completed'] ?? 0),
            Stat::make('Ready for Pickup', $counts['ready_for_pick_up'] ?? 0),
        ];
    }
}
