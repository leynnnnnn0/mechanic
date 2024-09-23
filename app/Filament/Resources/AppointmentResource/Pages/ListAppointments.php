<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Enum\AppointmentStatus;
use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Support\Facades\DB;

class ListAppointments extends ListRecords
{

    public function getTabs(): array
    {
        $tabs = [];

        $tabs[] = Tab::make('All Appointments')
            ->badge(Appointment::count());

        $statusCounts = Appointment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        foreach (AppointmentStatus::cases() as $status) {
            $key = $status;
            $statusValue = $status->value;
            $count = $statusCounts->get($statusValue, 0);

            $tabs[] = Tab::make(ucfirst($statusValue))
                ->badge($count)
                ->badgeColor($key->getColor())
                ->modifyQueryUsing(function ($query) use ($statusValue) {
                    return $query->where('status', $statusValue);
                });
        }

        return $tabs;
    }
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
