<?php

namespace App\Filament\Resources;


use App\Enum\Specialization;
use App\Filament\Resources\MechanicResource\Pages;
use App\Models\Mechanic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class MechanicResource extends Resource
{
    protected static ?string $model = Mechanic::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'People';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Details')->schema([
                    Forms\Components\TextInput::make('first_name')
                        ->required(),

                    Forms\Components\TextInput::make('middle_name'),

                    Forms\Components\TextInput::make('last_name')
                        ->required(),

                    Forms\Components\DatePicker::make('date_of_birth')
                        ->required(),
                ])->columns(2),

                Forms\Components\Section::make('Professional Details')->schema([
                    Forms\Components\Select::make('specialization')
                        ->options(Specialization::class)
                        ->required(),
                ])->columns(2),

                Forms\Components\Section::make('Contact Details')->schema([
                    Forms\Components\TextInput::make('email')->email()->required(),
                    Forms\Components\TextInput::make('phone_number')->required(),
                ])->columns(2),

                Forms\Components\Section::make('Address Details')->schema([
                    Forms\Components\TextInput::make('street_address')
                        ->columnSpan(2)->required(),
                    Forms\Components\TextInput::make('city')->required(),
                    Forms\Components\TextInput::make('barangay')->required(),
                    Forms\Components\TextInput::make('state_or_province')->required(),
                    Forms\Components\TextInput::make('postal_code')->required(),
                ])->columns(2),

                Forms\Components\Section::make('Others')->schema([
                    Forms\Components\TextInput::make('password')->password()->revealable()->required()->dehydrateStateUsing(fn(string $state): string => Hash::make($state)),
                ])->columns(2),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-o-envelope'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->icon('heroicon-o-phone'),
                Tables\Columns\TextColumn::make('specialization')
                    ->badge()

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
            'index' => Pages\ListMechanics::route('/'),
            'create' => Pages\CreateMechanic::route('/create'),
            'edit' => Pages\EditMechanic::route('/{record}/edit'),
        ];
    }
}
