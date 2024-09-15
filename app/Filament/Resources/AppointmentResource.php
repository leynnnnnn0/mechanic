<?php

namespace App\Filament\Resources;

use App\Enum\AppointmentStatus;
use App\Enum\Role;
use App\Enum\Service;
use App\Enum\TimeSlot;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\Widgets\AppointmentOverview;
use App\Http\Controllers\Api\CarDetail;
use App\Models\Appointment;
use App\Models\Car;
use Carbon\Carbon;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Random\RandomException;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'Shop';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;


    /**
     * @throws RandomException
     */

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    //First Step
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
                            ->reactive()
                            ->label('Customer')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\Section::make('Personal Details')->schema([
                                    Forms\Components\TextInput::make('first_name'),
                                    Forms\Components\TextInput::make('middle_name'),
                                    Forms\Components\TextInput::make('last_name'),
                                    Forms\Components\DatePicker::make('date_of_birth'),
                                ])->columns(2),

                                Forms\Components\Section::make('Contact Details')->schema([
                                    Forms\Components\TextInput::make('email')->email(),
                                    Forms\Components\TextInput::make('phone_number'),
                                ])->columns(2),

                                Forms\Components\Section::make('Address Details')->schema([
                                    Forms\Components\TextInput::make('street_address')
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('city'),
                                    Forms\Components\TextInput::make('barangay'),
                                    Forms\Components\TextInput::make('state_or_province'),
                                    Forms\Components\TextInput::make('postal_code'),
                                ])->columns(2),

                                Forms\Components\Section::make('Others')->schema([
                                    Forms\Components\TextInput::make('password')->password(),
                                    Forms\Components\Select::make('role')
                                        ->options(Role::class)
                                        ->required()
                                ])->columns(2),
                            ])
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create customer')
                                    ->modalSubmitActionLabel('Create customer')
                                    ->modalWidth('lg');
                            }),

                        Forms\components\Select::make('car_id')
                            ->options(fn(Get $get): Collection => Car::query()
                                ->where('user_id', $get('user_id'))
                                ->get()
                                ->mapWithKeys(function ($car) {
                                    return [$car->id => "{$car->make} {$car->model} - {$car->color} ({$car->year})"];
                                }))
                            ->preload()
                            ->searchable(['make', 'model', 'color', 'year'])
                            ->label('Car')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\Section::make('Car Details')->schema([
                                    Forms\Components\Select::make('make')
                                        ->options(CarDetail::getCarMakes())
                                        ->searchable()
                                        ->required(),

                                    Forms\Components\TextInput::make('model')
                                        ->required(),

                                    Forms\Components\Select::make('year')
                                        ->options(CarDetail::getCarYears())
                                        ->required(),

                                    Forms\Components\TextInput::make('license_plate')
                                        ->required(),

                                    Forms\Components\TextInput::make('color')
                                        ->required(),
                                ])->columns(2)
                            ])
                            ->createOptionUsing(function (array $data) {
                                return Car::create($data);
                            })
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create Car')
                                    ->modalSubmitActionLabel('Create Car')
                                    ->modalWidth('lg');
                            }),
                        Forms\components\Select::make('service_type')
                            ->options(Service::class)
                            ->searchable()
                            ->required(),

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
                        Forms\Components\Hidden::make('status')->default('pending'),

                        DatePicker::make('appointment_date')->required()->label('Appointment Date'),

                        Forms\Components\ToggleButtons::make('appointment_time')
                            ->options(TimeSlot::class)
                            ->inline()
                            ->required(),

                        Forms\Components\ToggleButtons::make('status')
                            ->options(AppointmentStatus::class)
                            ->inline()
                            ->default('pending')
                            ->hidden(fn (Get $get, string $context): bool => $context !== 'edit')
                            ->required()
                    ])->columns(2),

                ])->columnSpanFull()->submitAction(new HtmlString(Blade::render(<<<BLADE
                                        <x-filament::button
                                        type="submit"
                                        size="sm"
                                        >
                                        Submit
                                        </x-filament::button>
                                        BLADE))),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()->schema([
                    TextEntry::make('appointment_number'),
                    TextEntry::make('user.full_name')->label('Client Name'),
                    TextEntry::make('car.car_details')->label('Car Details'),
                    TextEntry::make('service_type')->label('Service Type'),
                    TextEntry::make('description')->label('Description'),
                    TextEntry::make('additional_notes')->label('Additional Notes'),
                    TextEntry::make('emergency')->label('Is Emergency?'),
                    TextEntry::make('towed')->label('Needs To be Towed?'),
                    TextEntry::make('appointment_time')->label('Appointment Time'),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn(string $state): string => AppointmentStatus::from($state)->getColor()),
                    ImageEntry::make('attachments.file_path')->label('Attachment'),
                ])->columns(2)
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            AppointmentOverview::class
        ]; // TODO: Change the autogenerated stub
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('appointment_number'),
                TextColumn::make('user.full_name')->label('Customer Name'),
                TextColumn::make('service_type'),
                TextColumn::make('status')->badge()
                    ->formatStateUsing(fn(string $state) => AppointmentStatus::from($state)->getLabel())
                    ->color(fn(string $state): string => AppointmentStatus::from($state)->getColor()),
                TextColumn::make('appointment_date')
                    ->formatStateUsing(fn(string $state) => Carbon::parse($state)->format('F d, Y'))
                    ->label('Appointment Date')
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(AppointmentStatus::class)
                    ->attribute('status')
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('Work Started')
                    ->url(fn (Appointment $appointment) => self::getUrl('create-service-job', ['record' => $appointment]))
                    ->visible(fn(Appointment $appointment):bool => $appointment->status === 'confirmed')
                    ->icon('heroicon-o-flag'),

                Tables\Actions\Action::make('Confirm')
                ->action(function (Appointment $appointment) {
                    $appointment->status = AppointmentStatus::CONFIRMED;
                    $appointment->save();
                })
                ->color(AppointmentStatus::CONFIRMED->getColor())
                ->icon('heroicon-o-check')
                ->visible(fn(Appointment $appointment):bool => $appointment->status !== 'cancelled' && $appointment->status !== 'confirmed'&& $appointment->status !== 'work started'),

                Tables\Actions\Action::make('Cancel')
                    ->action(function (Appointment $appointment) {
                        $appointment->status = AppointmentStatus::CANCELLED;
                        $appointment->save();
                    })
                    ->color(AppointmentStatus::CANCELLED->getColor())
                    ->visible(fn(Appointment $appointment):bool => $appointment->status !== 'cancelled')
                    ->icon('heroicon-o-x-mark'),
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
            'view'=> Pages\ViewAppointmentDetails::route('/{record}'),
            'create-service-job' => Pages\CreateServiceJob::route('/{record}/create-service-job'),
        ];
    }
    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewAppointmentDetails::class,
            Pages\EditAppointment::class
        ]);
    }
}
