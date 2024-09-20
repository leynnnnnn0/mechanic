<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\CarResource\Pages;
use App\Filament\Customer\Resources\CarResource\RelationManagers;
use App\Http\Controllers\Api\CarDetail;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'My Vehicles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Car Details')
                    ->schema([
                        Hidden::make('customer_id')->default(auth()->user()->customer_id),
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
                TextColumn::make('make'),
                TextColumn::make(name: 'model'),
                TextColumn::make('year'),
                TextColumn::make('color'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('customer_id', auth()->user()->customer_id);
    }
}
