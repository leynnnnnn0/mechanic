<?php

namespace App\Filament\Resources\ServiceJobResource\Pages;

use App\Filament\Resources\ServiceJobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceJobs extends ListRecords
{
    protected static string $resource = ServiceJobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
