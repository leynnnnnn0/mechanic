<?php

namespace App\Filament\Customer\Resources\CustomerResource\Pages;

use App\Enum\AppointmentStatus;
use App\Filament\Customer\Resources\CustomerResource;
use App\Livewire\Appointment;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
