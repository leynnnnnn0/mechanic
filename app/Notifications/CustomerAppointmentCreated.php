<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;
use Filament\Notifications\Notification as FilamentNotification;

class CustomerAppointmentCreated extends BaseNotification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return FilamentNotification::make()
            ->title("New appointment has been created.")
            ->body("Appointment Number {$this->appointment} has been created.")
            ->getDatabaseMessage();
    }
}
