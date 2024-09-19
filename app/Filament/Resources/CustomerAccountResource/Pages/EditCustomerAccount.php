<?php

namespace App\Filament\Resources\CustomerAccountResource\Pages;

use App\Filament\Resources\CustomerAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerAccount extends EditRecord
{
    protected static string $resource = CustomerAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
