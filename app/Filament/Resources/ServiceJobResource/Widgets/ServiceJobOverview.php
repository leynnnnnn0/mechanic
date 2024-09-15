<?php

namespace App\Filament\Resources\ServiceJobResource\Widgets;

use App\Models\Appointment;
use App\Models\ServiceJob;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ServiceJobOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $counts = ServiceJob::query()
            ->selectRaw('status, count(*) as count')
            ->whereIn('status', ['scheduled', 'in_progress', 'ready_for_pick_up'])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            Stat::make('SCHEDULED', $counts['scheduled'] ?? 0),
            Stat::make('IN PROGRESS', $counts['in_progress'] ?? 0),
            Stat::make('READY FOR PICK UP', $counts['ready_for_pick_up'] ?? 0),
        ];
    }

}
