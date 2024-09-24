<?php

namespace App\Filament\Customer\Resources\CustomerResource\Pages;

use App\Filament\Customer\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Resources\Pages\Page;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;

class MyDetails extends Page
{
    protected static string $resource = CustomerResource::class;

    protected static string $view = 'filament.customer.resources.customer-resource.pages.my-details';

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record(Customer::with('account')->find(auth('customer')->user()->customer_id))
            ->schema([
                Section::make('Personal Details')->schema([
                    TextEntry::make('first_name'),
                    TextEntry::make('middle_name'),
                    TextEntry::make('last_name'),
                    TextEntry::make('date_of_birth'),
                ])->columns(2),
                Section::make('Contact Details')->schema([
                    TextEntry::make('email'),
                    TextEntry::make('phone_number'),
                ])->columns(2),
                Section::make('Address Details')->schema([
                    TextEntry::make('street_address'),
                    TextEntry::make('city'),
                    TextEntry::make('barangay'),
                    TextEntry::make('state_or_province')
                        ->label('State/Province'),
                    TextEntry::make('postal_code'),
                ])->columns(2),
                Section::make('Account Details')->schema([
                    TextEntry::make('account.username')->label('Username'),
                    TextEntry::make('account.password')->label('Password')->formatStateUsing(fn($state) => '*************')
                ])->columns(2)
            ]);
    }
}
