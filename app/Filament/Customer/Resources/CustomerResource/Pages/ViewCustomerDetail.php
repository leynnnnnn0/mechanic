<?php

namespace App\Filament\Customer\Resources\CustomerResource\Pages;

use App\Filament\Customer\Resources\CustomerResource;
use App\Models\Customer;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;

class ViewCustomerDetail extends Page
{
    protected static string $resource = CustomerResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record(Customer::with('account')->find(auth('customer')->user()->customer_id))
            ->schema([
                Section::make()->schema([
                    TextEntry::make('email'),

                ])->columns(2)
            ]);
    }
}
