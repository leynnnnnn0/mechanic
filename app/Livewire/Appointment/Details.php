<?php

namespace App\Livewire\Appointment;

use Livewire\Attributes\On;
use Livewire\Component;

class Details extends Component
{
    public $appointmentDetails;
    #[On('appointmentCreated')]
    public function mount($details)
    {
        $this->appointmentDetails = $details;
    }
    public function render()
    {
        return view('livewire.appointment.details');
    }
}
