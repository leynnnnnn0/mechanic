<?php

namespace App\Filament\Customer\Resources;

use App\Enum\Regex;
use App\Filament\Customer\Resources\CustomerResource\Pages;
use App\Filament\Customer\Resources\CustomerResource\Pages\EditCustomer;
use App\Filament\Customer\Resources\CustomerResource\Pages\MyDetails;
use App\Models\Customer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = "My Details";
    protected static ?int $navigationSort = 5;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;


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
                        TextInput::make('email')
                            ->rule('sometimes')
                            ->email()
                            ->regex(Regex::EMAIL->value),

                        TextInput::make('phone_number')
                            ->required()
                            ->numeric()
                            ->regex(Regex::PHONE_NUMBER->value)
                            ->validationMessages([
                                'regex' => 'Invalid :attribute format'
                            ]),
                    ])->columns(2),

                Section::make('Address Details')
                    ->schema([
                        TextInput::make('street_address')->required()->columnSpanFull(),
                        TextInput::make('city')->required(),
                        TextInput::make('barangay')->required(),
                        TextInput::make('state_or_province')->required(),
                        TextInput::make('postal_code')->required(),
                    ])->columns(2),

                // Section::make('Account Details')
                //     ->schema([
                //         TextInput::make('username')
                //             ->afterStateHydrated(fn($set, $state, $record) => $state ?: $set('username', $record->account->username))
                //             ->required(),
                //         TextInput::make('password')
                //             ->required()
                //             ->password()
                //             ->revealable()
                //             ->minLength(8)
                //             ->dehydrateStateUsing(fn($state) => !empty($state) ? bcrypt($state) : null),
                //     ])->columns(2),
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
                Tables\Actions\ViewAction::make()
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
            // 'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
            'index' => Pages\MyDetails::route('/')
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            CustomerResource\Pages\MyDetails::class,
            EditCustomer::class
        ]);
    }
}
