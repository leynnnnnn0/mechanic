<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\ServiceJobResource\Pages;
use App\Filament\Customer\Resources\ServiceJobResource\RelationManagers;
use App\Models\Car;
use App\Models\ServiceJob;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceJobResource extends Resource
{
    protected static ?string $model = ServiceJob::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service_job_id'),
                TextColumn::make('car.carDetails'),
                TextColumn::make('service_type'),
                TextColumn::make('status')->badge(),
                TextColumn::make('mechanic.full_name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListServiceJobs::route('/'),
            'create' => Pages\CreateServiceJob::route('/create'),
            'edit' => Pages\EditServiceJob::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Get customer id
        $customerId = auth()->user()->customer_id;
        // Get all the cars associated to it
        $vehicles = Car::select('id')->where('customer_id', $customerId)->get();
        // Get services associated to the vehicles
        return parent::getEloquentQuery()->whereIn('car_id', $vehicles->toArray());
    }
}
