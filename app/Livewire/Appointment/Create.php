<?php

namespace App\Livewire\Appointment;

use App\Enum\Service;
use App\Enum\TimeSlot;
use App\Http\Controllers\Api\CarDetail;
use App\Livewire\Forms\AppointmentForm;
use Livewire\Component;

class Create extends Component
{
    public AppointmentForm $form;
    public array $makes;
    public array $services;
    public array $timeSlots;
    public int $step = 1;

    public function previousStep()
    {
        $this->step -= 1;
    }

    public function nextStep()
    {
        $this->step += 1;
    }
    public function mount()
    {
        $this->makes = CarDetail::getCarMakes();
        $this->services = Service::cases();
        $this->timeSlots = TimeSlot::cases();
    }
    public function render()
    {
        return view('livewire.appointment.create');
    }

    public function submit()
    {
        $appointmentDetails = $this->form->store();
        dd($appointmentDetails);
    }
}
