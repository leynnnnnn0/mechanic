<?php

namespace App\Filament\Customer\Resources;

use App\Enum\AppointmentStatus;
use App\Enum\Service;
use App\Enum\TimeSlot;
use App\Filament\Customer\Resources\AppointmentResource\Pages;
use App\Filament\Customer\Resources\AppointmentResource\Pages\EditAppointment;
use App\Filament\Customer\Resources\AppointmentResource\Pages\ViewAppointmentDetails;
use App\Http\Controllers\Api\CarDetail;
use App\Models\Appointment;
use App\Models\Car;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'My appointments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make()->schema([
                    Wizard\Step::make('First Step')->schema([
                        Hidden::make('status')->default(AppointmentStatus::PENDING),
                        Forms\components\TextInput::make('appointment_number')
                            ->default('AN-' . random_int(100000, 999999))
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(32)
                            ->label('Appointment Number')
                            ->unique(Appointment::class, 'id', ignoreRecord: true)
                            ->columnSpanFull(),

                        Select::make('car_id')
                            ->options(fn(): Collection => Car::query()
                                ->where('customer_id', auth()->user()->customer_id)
                                ->get()
                                ->mapWithKeys(function ($car) {
                                    return [$car->id => "{$car->car_details}"];
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
                                $data['customer_id'] = auth()->user()->customer_id;
                                $car = Car::create($data);
                                return $car;
                            })
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create Car')
                                    ->modalSubmitActionLabel('Create Car')
                                    ->modalWidth('lg');
                            }),

                        Select::make('service_type')
                            ->options(function () {
                                $data = array_map(fn($case) => $case->value, Service::cases());
                                return array_combine($data, $data);
                            })
                            ->required(),

                        Textarea::make('description')
                            ->extraInputAttributes(['style' => 'resize: none;']),

                        Textarea::make('additional_notes')
                            ->label('Notes')
                            ->extraInputAttributes(['style' => 'resize: none;']),

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

                    Wizard\Step::make('Second Step')->schema([
                        DatePicker::make('appointment_date')
                            ->minDate(Carbon::today())
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('appointment_time', null);
                            })
                            ->native(false),

                        ToggleButtons::make('appointment_time')
                            ->options(fn(Get $get) => TimeSlot::getAvailableOptions($get('appointment_date')))
                            ->inline()
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.date" />')))
                            ->required(),
                    ]),

                    Forms\Components\Wizard\Step::make('Third Step')
                        ->schema([
                            Repeater::make('attachments')
                                ->relationship('attachments')
                                ->schema([
                                    Forms\components\FileUpload::make('attachment')
                                        ->previewable(false)
                                        ->label('')
                                        ->disk('public')
                                        ->directory('appointment-attachments')
                                        ->columnSpanFull()
                                ])->columnSpanFull(),
                        ])->columns(2),
                ])->columnSpanFull()->submitAction(new HtmlString(html: Blade::render(<<<BLADE
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
                TextColumn::make('car.carDetails'),
                TextColumn::make('service_type'),
                TextColumn::make('status')->badge()
                    ->formatStateUsing(fn(string $state) => AppointmentStatus::from($state)->getLabel())
                    ->color(fn(string $state): string => AppointmentStatus::from($state)->getColor()),
                TextColumn::make('appointment_date')
                    ->formatStateUsing(fn(string $state) =>
                    Carbon::parse($state)->diffInDays(Carbon::today()) >= 3 ? Carbon::parse($state)->format('F d, Y') : Carbon::parse($state)->diffForHumans())
                    ->label('Appointment Date'),
                TextColumn::make('appointment_time'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make()
                    ->hidden(fn(Appointment $appointment): bool => $appointment->status !== 'pending'),

                Tables\Actions\Action::make('Cancel')
                    ->action(function (Appointment $appointment) {
                        $appointment->status = AppointmentStatus::CANCELLED;
                        $appointment->save();
                    })
                    ->color(AppointmentStatus::CANCELLED->getColor())
                    ->visible(fn(Appointment $appointment): bool => $appointment->status !== 'cancelled' && $appointment->status === 'pending')
                    ->icon('heroicon-o-x-mark'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'view' => ViewAppointmentDetails::route('/{record}/appointment')
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditAppointment::class
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        // Get the id of the customer
        $customerId = auth()->user()->customer_id;
        // Get the cars associated to that customer 
        $vehicles = Car::select('id')->where('customer_id', $customerId)->get();
        // Fetch all the appointments associated to that vehicle
        return parent::getEloquentQuery()->whereIn('car_id', $vehicles->toArray());
    }
}
