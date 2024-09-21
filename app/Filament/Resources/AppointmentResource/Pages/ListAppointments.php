<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Enum\AppointmentStatus;
use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;


class ListAppointments extends ListRecords
{

    public function getTabs(): array
    {
        $tabs = [];

        $tabs[] = Tab::make('All Appointments')
            ->badge(Appointment::count());

        foreach (AppointmentStatus::cases() as $status) {
            $key = $status;
            $status = $status->value;
            $tabs[] = Tab::make(ucfirst($status))
                ->badge(Appointment::where('status', $status)->count())
                ->badgeColor($key->getColor())
                ->modifyQueryUsing(function ($query) use ($status) {
                    return $query->where('status', $status);
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
