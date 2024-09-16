<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Details')
                    ->schema([
                        TextInput::make('first_name')->required()->string()->minLength(2),
                        TextInput::make('middle_name')->string()->minLength('2'),
                        TextInput::make('last_name')->required()->string()->minLength(2),
                        DatePicker::make('date_of_birth')->required()->date()->native(false),
                    ])->columns(2),

                Section::make('Contact Details')
                    ->schema([
                        TextInput::make('email')->required()->email(),
                        TextInput::make('phone_number')->required()->numeric(),
                    ])->columns(2),

                Section::make('Address Details')
                    ->schema([
                        TextInput::make('street_address')->required()->columnSpanFull(),
                        TextInput::make('city')->required(),
                        TextInput::make('barangay')->required(),
                        TextInput::make('state_or_province')->required(),
                        TextInput::make('postal_code')->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
