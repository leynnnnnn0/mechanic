<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;
use Filament\Notifications\Notification as FilamentNotification;

class AppointmentStatusChanged extends BaseNotification
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
            ->title("Appointment Status Updated")
            ->body("Appointment {$this->appointment->appointment_number} status updated to what")
            ->getDatabaseMessage();
    }
}
