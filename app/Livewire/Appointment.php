<?php

namespace App\Livewire;

use App\Enum\Service;
use App\Enum\TimeSlot;
use App\Http\Controllers\Api\CarDetail;
use Livewire\Attributes\On;
use Livewire\Component;

class Appointment extends Component
{
    public bool $displayDetails = false;
    public $details;
    public function render()
    {
        return view('livewire.appointment');
    }
    #[On('appointmentCreated')]
    public function showAppointmentDetails($details)
    {
        $this->details = $details;
        $this->displayDetails = true;
    }
}
