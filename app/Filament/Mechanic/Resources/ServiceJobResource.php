<?php

namespace App\Filament\Mechanic\Resources;

use App\Filament\Mechanic\Resources\ServiceJobResource\Pages;
use App\Filament\Mechanic\Resources\ServiceJobResource\RelationManagers;
use App\Models\ServiceJob;
use Carbon\Carbon;
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
    protected static ?string $navigationLabel = 'My Service Jobs';

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
                TextColumn::make('car.customer.full_name'),
                TextColumn::make('car.car_details'),
                TextColumn::make('service_type'),
                TextColumn::make('status')->badge(),
                TextColumn::make('start_date')->formatStateUsing(fn($state) => Carbon::parse($state)->format('F d, Y'))
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
            'index' => Pages\ListServiceJobs::route('/'),
            'create' => Pages\CreateServiceJob::route('/create'),
            'edit' => Pages\EditServiceJob::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Get the mechanic id
        $mechanicId = auth()->user()->id;
        return parent::getEloquentQuery()->where('mechanic_id', $mechanicId);
    }
}
