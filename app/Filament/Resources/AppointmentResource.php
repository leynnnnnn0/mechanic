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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
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
//                     First Step
                    Forms\components\Wizard\Step::make('First Step')
                    ->schema([
                        Forms\components\TextInput::make('appointment_number')
                            ->default('AN-' . random_int(100000, 999999))
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(32)
                            ->label('Appointment Number')
                            ->unique(Appointment::class, 'id', ignoreRecord: true)
                            ->columnSpanFull(),
                        Forms\components\Select::make('user_id')
                            ->relationship('user')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name'])
                            ->live()
                            ->label('Customer')
                            ->required(),
                        Forms\components\Select::make('car_id')
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
                        Forms\components\Select::make('service_type')
                            ->options(Service::class)
                            ->searchable()
                            ->required(),
//                        DateTimePicker::make('date_and_time')->required(),
                        TextArea::make('description'),
                        TextArea::make('additional_notes'),
                        Group::make()
                        ->relationship('attachments')
                        ->schema([
                            Forms\components\FileUpload::make('file_path')
                                ->label('Attachment')
                                ->disk('public')
                                ->directory('appointment-attachments')
                                ->columnSpanFull()
                        ]),
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

                    // Second Step
                    Forms\Components\Wizard\Step::make('Second Step')
                    ->schema([
                        DatePicker::make('appointment_date')->required()->label('Appointment Date'),
                        Forms\Components\Select::make('appointment_time')
                            ->label('Appointment Time')
                            ->options([
                                '08:00-09:00' => '8:00 am - 9:00 am',
                                '09:00-10:00' => '9:00 am - 10:00 am',
                                '10:00-11:00' => '10:00 am - 11:00 am',
                                '11:00-12:00' => '11:00 am - 12:00 pm',
                                '13:00-14:00' => '1:00 pm - 2:00 pm',
                                '14:00-15:00' => '2:00 pm - 3:00 pm',
                                '15:00-16:00' => '3:00 pm - 4:00 pm',
                                '16:00-17:00' => '4:00 pm - 5:00 pm',
                            ])
                            ->required(),
                    ])->columns(2),
                    Forms\Components\Wizard\Step::make('Third Step')
                        ->schema([

                        ])

                ])->columnSpanFull()
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                                                        <x-filament::button
                                                            type="submit"
                                                            size="sm"
                                                        >
                                                            Submit
                                                        </x-filament::button>
                                                    BLADE))),

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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
