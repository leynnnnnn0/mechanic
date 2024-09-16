<?php

namespace App\Filament\Resources;

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
use App\Models\Appointment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Get;
use Filament\Forms\Set;

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
                        ->required()
                        ->label('Service Job Number'),

                    Select::make('appointment_id')
                        ->options(fn() => Appointment::query()->select(['id', 'appointment_number'])->get()->pluck('appointment_number', 'id'))
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            $appointmentId = $get('appointment_id');
                            $appointment = Appointment::find($appointmentId);
                            if ($appointment) {
                                $set('car_id', $appointment->car->carDetails);
                                $set('service_type', $appointment->service_type);
                            }
                        })
                        ->required(),

                    TextInput::make('car_id')
                        ->label('Car Details')
                        ->disabled()
                        ->required(),

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
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('start_date')
                    ->formatStateUsing(fn($state) => Carbon::make($state)->diffForHumans()),
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
            'index' => Pages\ListServiceJobs::route('/'),
            'create' => Pages\CreateServiceJob::route('/create'),
            'edit' => Pages\EditServiceJob::route('/{record}/edit'),
        ];
    }
}
