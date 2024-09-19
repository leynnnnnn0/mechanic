<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerAccountResource\Pages;
use App\Models\CustomerAccount;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomerAccountResource extends Resource
{
    protected static ?string $model = CustomerAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'People';

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
                TextColumn::make('customer.full_name')->label('Customer'),
                TextColumn::make('username'),
                TextColumn::make('customer.email')
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
            'index' => Pages\ListCustomerAccounts::route('/'),
            // 'create' => Pages\CreateCustomerAccount::route('/create'),
            // 'edit' => Pages\EditCustomerAccount::route('/{record}/edit'),
        ];
    }
}
