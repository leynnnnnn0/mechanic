<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Http\Controllers\Api\CarDetail;
use App\Models\Car;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Actions\Action;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;
    protected static ?string $navigationGroup = 'Shop';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Car Details')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name'])
                            ->live()
                            ->label('Owner')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\Section::make('Personal Details')->schema([
                                    Forms\Components\TextInput::make('first_name'),
                                    Forms\Components\TextInput::make('middle_name'),
                                    Forms\Components\TextInput::make('last_name'),
                                    Forms\Components\DatePicker::make('date_of_birth'),
                                ])->columns(2),

                                Forms\Components\Section::make('Contact Details')->schema([
                                    Forms\Components\TextInput::make('email')->email(),
                                    Forms\Components\TextInput::make('phone_number'),
                                ])->columns(2),

                                Forms\Components\Section::make('Address Details')->schema([
                                    Forms\Components\TextInput::make('street_address')
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('city'),
                                    Forms\Components\TextInput::make('barangay'),
                                    Forms\Components\TextInput::make('state_or_province'),
                                    Forms\Components\TextInput::make('postal_code'),
                                ])->columns(2),
                            ])
                            ->createOptionUsing(function (array $data) {
                                return Customer::create($data);
                            })
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create customer')
                                    ->modalSubmitActionLabel('Create customer')
                                    ->modalWidth('lg');
                            }),

                        Forms\Components\Select::make('make')
                            ->options(CarDetail::getCarMakes())
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('model')->required(),
                        Forms\Components\Select::make('year')
                            ->options(CarDetail::getCarYears())
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('license_plate')->required(),
                        Forms\Components\TextInput::make('color')->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.full_name')->label('Owner')
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('make')->searchable(),
                TextColumn::make('model')->searchable(),
                TextColumn::make('year')->searchable(),
                TextColumn::make('license_plate')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
