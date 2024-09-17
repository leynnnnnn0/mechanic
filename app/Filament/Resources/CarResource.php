<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Http\Controllers\Api\CarDetail;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                            ->required(),
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
