<?php

namespace App\Filament\Mechanic\Resources\ServiceJobResource\Pages;

use App\Filament\Mechanic\Resources\ServiceJobResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceJob extends CreateRecord
{
    protected static string $resource = ServiceJobResource::class;
    protected static bool $canCreateAnother = false;
}
