<?php

namespace App\Filament\Mechanic\Resources\ServiceJobResource\Pages;

use App\Filament\Mechanic\Resources\ServiceJobResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceJob extends EditRecord
{
    protected static string $resource = ServiceJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
