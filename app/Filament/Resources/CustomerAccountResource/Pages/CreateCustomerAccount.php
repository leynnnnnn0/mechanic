<?php

namespace App\Filament\Resources\CustomerAccountResource\Pages;

use App\Filament\Resources\CustomerAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerAccount extends CreateRecord
{
    protected static string $resource = CustomerAccountResource::class;
    
}
