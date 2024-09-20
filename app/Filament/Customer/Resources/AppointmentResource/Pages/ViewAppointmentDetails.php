<?php

namespace App\Filament\Customer\Resources\AppointmentResource\Pages;

use App\Enum\AppointmentStatus;
use Filament\Infolists\Infolist;

use App\Filament\Customer\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;

class ViewAppointmentDetails extends ViewRecord
{
    protected static string $resource = AppointmentResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()->schema([
                    TextEntry::make('appointment_number'),
                    TextEntry::make('car.car_details')->label('Car Details'),
                    TextEntry::make('service_type')->label('Service Type'),
                    TextEntry::make('display_description')->label('Description'),
                    TextEntry::make('display_notes')->label('Additional Notes'),
                    TextEntry::make('emergency')->label('Is Emergency?'),
                    TextEntry::make('towed')->label('Needs To be Towed?'),
                    TextEntry::make('appointment_date')->label('Appointment Time'),
                    TextEntry::make('appointment_time')->label('Appointment Date'),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn(string $state): string => AppointmentStatus::from($state)->getColor()),
                    ImageEntry::make('attachments.attachment')->label('Attachment'),
                ])->columns(2)
            ]);
    }
}
