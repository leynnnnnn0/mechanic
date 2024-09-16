<?php

namespace App\Filament\Resources;

use App\Enum\Role;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'People';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Details')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')->required()->string()->minLength(2),
                        Forms\Components\TextInput::make('middle_name'),
                        Forms\Components\TextInput::make('last_name')->required()->string()->minLength(2),
                        Forms\Components\DatePicker::make('date_of_birth')->required()->date(),
                    ])->columns(2),
                Forms\Components\Section::make('Contact Details')
                    ->schema([
                        Forms\Components\TextInput::make('email')->required()->email(),
                        Forms\Components\TextInput::make('phone_number')->required()->numeric(),
                    ])->columns(2),
                Forms\Components\Section::make('Address Details')
                    ->schema([
                        Forms\Components\TextInput::make('street_address')->required()->columnSpanFull(),
                        Forms\Components\TextInput::make('city')->required(),
                        Forms\Components\TextInput::make('barangay')->required(),
                        Forms\Components\TextInput::make('state_or_province')->required(),
                        Forms\Components\TextInput::make('postal_code')->required(),
                    ])->columns(2),
                Forms\Components\Section::make('Others')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            ->default(function () {
                                // Generate a random password
                                return Str::random(10);
                            })->revealable(),
                        Forms\Components\Select::make('role')
                            ->options(Role::class)
                            ->native()
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->searchable(['email']),
                TextColumn::make('phone_number')
                    ->searchable(['phone_number']),
                TextColumn::make('role')

            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
