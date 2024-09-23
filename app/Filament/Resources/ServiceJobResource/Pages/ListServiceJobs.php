<?php

namespace App\Filament\Resources\ServiceJobResource\Pages;

use App\Enum\RepairStatus;
use App\Filament\Resources\ServiceJobResource;
use App\Models\ServiceJob;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Support\Facades\DB;

class ListServiceJobs extends ListRecords
{
    protected static string $resource = ServiceJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $tabs[] = Tab::make('All Appointments')
            ->badge(ServiceJob::count());

        $statusCounts = ServiceJob::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        foreach (RepairStatus::cases() as $status) {
            $key = $status;
            $statusValue = $status->value;
            $count = $statusCounts->get($statusValue, 0);

            $tabs[] = Tab::make(ucfirst($statusValue))
                ->badge($count)
                ->modifyQueryUsing(function ($query) use ($statusValue) {
                    return $query->where('status', $statusValue);
                });
        }

        return $tabs;
    }
}
