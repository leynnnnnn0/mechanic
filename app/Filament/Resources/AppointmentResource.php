<?php

namespace App\Filament\Resources;

use App\Enum\Boolean;
use App\Enum\Service;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\AppointmentAttachment;
use App\Models\Car;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ramsey\Collection\Collection;
use Random\RandomException;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'Shop';

    /**
     * @throws RandomException
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Appointment Details')
                    ->schema([
                        Forms\Components\TextInput::make('appointment_number')
                            ->default('AN-' . random_int(100000, 999999))
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(32)
                            ->label('Appointment Number')
                            ->unique(Appointment::class, 'id', ignoreRecord: true)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name'])
                            ->live()
                            ->label('Customer')
                            ->required(),
                        Forms\Components\Select::make('car_id')
                            ->options(fn(Get $get): \Illuminate\Support\Collection => Car::query()
                                ->where('user_id', $get('user_id'))
                                ->get()
                                ->mapWithKeys(function ($car) {
                                    return [$car->id => "{$car->make} {$car->model} - {$car->color} ({$car->year})"];
                                }))
                            ->preload()
                            ->searchable(['make', 'model', 'color', 'year'])
                            ->label('Car')
                            ->required(),
                        Forms\Components\Select::make('service_type')
                            ->options(Service::class)
                            ->searchable()
                            ->required(),
                        DateTimePicker::make('date_and_time'),
                        TextArea::make('description'),
                        TextArea::make('additional_notes'),
                        Group::make()
                        ->relationship('attachments')
                        ->schema([
                            Forms\Components\FileUpload::make('file_path')
                                ->label('Attachment')
                                ->disk('public')
                                ->directory('appointment-attachments')
                                ->columnSpanFull()
                        ])->columnSpanFull(),
                        Radio::make('is_emergency')
                            ->label('Is Emergency?')
                            ->boolean()
                            ->required()
                            ->inline(),
                        Radio::make('to_be_towed')
                            ->boolean()
                            ->label('Needs To be Towed?')
                            ->required()
                            ->inline(),
                    ])->columns(2),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('appointment_number'),
                TextColumn::make('user.full_name')->label('Customer Name'),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('service_type'),
                TextColumn::make('date_and_time')->label('Appointment Date')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
