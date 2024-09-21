<?php

namespace App\Filament\Resources\ServiceJobResource\Pages;

use App\Enum\RepairStatus;
use App\Filament\Resources\ServiceJobResource;
use App\Models\ServiceJob;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

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

        foreach (RepairStatus::cases() as $status) {
            $key = $status;
            $status = $status->value;
            $tabs[] = Tab::make(ucfirst($status))
                ->badge(ServiceJob::where('status', $status)->count())
                ->modifyQueryUsing(function ($query) use ($status) {
                    return $query->where('status', $status);
                });
        }


        return $tabs;
    }
}
