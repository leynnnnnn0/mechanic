<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Enum\AppointmentStatus;
use App\Enum\PaymentStatus;
use App\Enum\RepairStatus;
use App\Enum\Service;
use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Mechanic;
use App\Models\ServiceJob;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class CreateServiceJob extends Page
{
    protected static string $resource = AppointmentResource::class;

    protected static string $view = 'filament.resources.appointment-resource.pages.create-service-job';
    use InteractsWithRecord;
    public ?array $data = [];

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->form->fill();
    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([
            Section::make('Service Details')->schema([
                TextInput::make('service_job_id')
                    ->default('SN-' . random_int(100000, 999999))
                    ->required()
                    ->label('Service Job Number')
                    ->required(),

                TextInput::make('appointment_number')
                    ->default($this->record->appointment_number)
                    ->disabled(),

                TextInput::make('car_id')
                    ->default($this->record->car->carDetails)
                    ->label('Car Details')
                    ->disabled(),

                Select::make('mechanic_id')
                    ->options(fn() => Mechanic::query()
                        ->select('id', 'first_name', 'last_name')
                        ->get()->mapWithKeys(fn($mechanic) => [$mechanic->id => $mechanic->full_name]))
                    ->label('Mechanic')
                    ->required(),

                ToggleButtons::make('status')
                    ->options(RepairStatus::class)
                    ->default('scheduled')
                    ->inline()
                    ->required(),

                Select::make('service_type')
                    ->default($this->record->service_type)
                    ->options(Service::class)
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
        ])->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Create Service Job')
                ->submit('save')->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Service Job has been created')
                        ->body('Service Job has been created')
                ),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        // $data['appointment_id'] = $this->record->id;
        $data['car_id'] = $this->record->car_id;
        ServiceJob::updateOrCreate($data);
        $record = Appointment::find($this->record->id);
        $record->status = AppointmentStatus::WORK_STARTED;
        $record->save();
        Notification::make()
            ->title('Created successfully')
            ->success()
            ->seconds(5)
            ->send();
        $this->redirect(AppointmentResource::getUrl('view', ['record' => $this->record]));
    }

    public function getSubNavigation(): array
    {
        return []; // TODO: Change the autogenerated stub
    }
}
