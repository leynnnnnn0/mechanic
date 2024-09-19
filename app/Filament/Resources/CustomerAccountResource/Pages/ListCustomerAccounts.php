<?php

namespace App\Filament\Resources\CustomerAccountResource\Pages;

use App\Filament\Resources\CustomerAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerAccounts extends ListRecords
{
    protected static string $resource = CustomerAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
