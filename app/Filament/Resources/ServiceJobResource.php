<?php

namespace App\Filament\Resources;

use App\Enum\AppointmentStatus;
use App\Filament\Resources\ServiceJobResource\Pages;
use App\Models\ServiceJob;
use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Select;
use App\Models\Mechanic;
use App\Enum\PaymentStatus;
use App\Enum\RepairStatus;
use App\Enum\Service;
use App\Http\Controllers\Api\CarDetail;
use App\Models\Car;
use App\Models\Customer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Str;
use Filament\Tables\Actions\ActionGroup;


class ServiceJobResource extends Resource
{
    protected static ?string $model = ServiceJob::class;
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Shop';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Service Details')->schema([
                    TextInput::make('service_job_id')
                        ->default('SN-' . random_int(100000, 999999))
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->label('Service Job Number'),

                    Select::make(name: 'customer_id')
                        ->relationship('car.customer')
                        ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                        ->searchable(['first_name', 'last_name'])
                        ->live()
                        ->reactive()
                        ->label('Customer')
                        ->required()
                        ->afterStateHydrated(function (Get $get, Set $set) {
                            // If editing and customer_id is not set, get it from the car
                            if ($get('car_id')) {
                                $car = Car::find($get('car_id'));
                                if ($car) {
                                    $set('customer_id', $car->customer_id);
                                }
                            }
                        })
                        ->createOptionForm([
                            Section::make('Personal Details')->schema([
                                TextInput::make('first_name'),
                                TextInput::make('middle_name'),
                                TextInput::make('last_name'),
                                DatePicker::make('date_of_birth'),
                            ])->columns(2),

                            Section::make('Contact Details')->schema([
                                TextInput::make('email')->email(),
                                TextInput::make('phone_number'),
                            ])->columns(2),

                            Section::make('Address Details')->schema([
                                TextInput::make('street_address')
                                    ->columnSpan(2),
                                TextInput::make('city'),
                                TextInput::make('barangay'),
                                TextInput::make('state_or_province'),
                                TextInput::make('postal_code'),
                            ])->columns(2),
                        ])
                        ->createOptionUsing(function (array $data) {
                            return Customer::create($data);
                        })
                        ->createOptionAction(function (Action $action) {
                            return $action
                                ->modalHeading('Create customer')
                                ->modalSubmitActionLabel('Create customer')
                                ->modalWidth('lg');
                        }),

                    Select::make('car_id')
                        ->options(fn(Get $get) => Car::query()
                            ->where('customer_id', $get('customer_id'))
                            ->get()
                            ->mapWithKeys(function ($car) {
                                return [$car->id => "{$car->car_details}"];
                            }))
                        ->preload()
                        ->searchable(['make', 'model', 'color', 'year'])
                        ->label('Car')
                        ->required()
                        ->createOptionForm([
                            Section::make('Car Details')->schema([
                                Select::make('make')
                                    ->options(CarDetail::getCarMakes())
                                    ->searchable()
                                    ->required(),

                                TextInput::make('model')
                                    ->required(),

                                Select::make('year')
                                    ->options(CarDetail::getCarYears())
                                    ->required(),

                                TextInput::make('license_plate')
                                    ->required(),

                                TextInput::make('color')
                                    ->required(),
                            ])->columns(2)
                        ])
                        ->createOptionUsing(function (array $data, Get $get, Set $set) {
                            $data['customer_id'] = $get('customer_id');
                            $car = Car::create($data);
                            $set('car_id', $car->id);
                            return $car;
                        })
                        ->createOptionAction(function (Action $action) {
                            return $action
                                ->modalHeading('Create Car')
                                ->modalSubmitActionLabel('Create Car')
                                ->modalWidth('lg');
                        }),

                    Select::make('service_type')
                        ->options(Service::class)
                        ->required(),

                    ToggleButtons::make('status')
                        ->options(RepairStatus::class)
                        ->default('scheduled')
                        ->inline()
                        ->required(),

                    Select::make('mechanic_id')
                        ->options(fn() => Mechanic::query()
                            ->select('id', 'first_name', 'last_name')
                            ->get()->mapWithKeys(fn($mechanic) => [$mechanic->id => $mechanic->full_name]))
                        ->label('Mechanic')
                        ->required(),

                    DatePicker::make('start_date'),
                    DatePicker::make('end_date'),

                    Textarea::make('description'),
                    Textarea::make('notes'),

                ])->columns(2),

                Section::make('Payment Details')->schema([
                    TextInput::make('estimated_cost'),
                    TextInput::make('final_cost'),
                    Select::make('payment_status')
                        ->options(PaymentStatus::class)
                        ->default('awaiting_payment')
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('car.carDetails')
                    ->label('Car Details'),
                Tables\Columns\TextColumn::make('mechanic.fullName'),
                Tables\Columns\TextColumn::make('service_type')->badge(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->formatStateUsing(fn($state) => Str::headline($state)),
                Tables\Columns\TextColumn::make('start_date')
                    ->formatStateUsing(fn($state) => Carbon::make($state)->diffForHumans()),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                ActionGroup::make([
                    ...collect(RepairStatus::cases())->map(function ($status) {
                        return Tables\Actions\Action::make($status->value)
                            ->requiresConfirmation()
                            ->modalHeading('Update Service Job Status')
                            ->modalDescription('Are you sure you\'d like to update the status?')
                            ->modalSubmitActionLabel('Yes, update it.')
                            ->action(function (ServiceJob $appointment) use ($status) {
                                $appointment->status = $status->value;
                                $appointment->save();
                            })
                            ->hidden(function (ServiceJob $appointment) use ($status) {
                                $values = array_map(fn($case) => $case->value, RepairStatus::cases());
                                $index = array_search($appointment->status, $values);
                                if ($index >= count($values) - 1) return true;
                                return $status->value !== RepairStatus::cases()[$index + 1]->value;
                            });
                    })
                ]),
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
}
