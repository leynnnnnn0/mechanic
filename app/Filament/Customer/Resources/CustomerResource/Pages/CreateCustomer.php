<?php

namespace App\Filament\Customer\Resources\CustomerResource\Pages;

use App\Filament\Customer\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
