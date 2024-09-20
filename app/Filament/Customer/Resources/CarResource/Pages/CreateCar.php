<?php

namespace App\Filament\Customer\Resources\CarResource\Pages;

use App\Filament\Customer\Resources\CarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCar extends CreateRecord
{
    protected static string $resource = CarResource::class;
}
