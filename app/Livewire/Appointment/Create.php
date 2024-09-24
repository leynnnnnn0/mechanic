<?php

namespace App\Livewire\Appointment;

use App\Enum\Service;
use App\Enum\TimeSlot;
use App\Http\Controllers\Api\CarDetail;
use App\Livewire\Forms\AppointmentForm;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Livewire\Component;

class Create extends Component
{
    public array $years;
    public AppointmentForm $form;
    public array $makes;
    public array $services;
    public array $timeSlots;
    public int $step = 1;
    public string $appointmentTime;

    public function trackLocation()
    {
        if ($this->form->city && $this->form->state_or_province) {
            $this->dispatch('updateMap', $this->form);
        }
    }

    public function previousStep()
    {
        $this->step -= 1;
    }

    public function nextStep()
    {
        match ($this->step) {
            2 => $this->form->validate($this->form->carRules()),
            3 => $this->form->validate($this->form->appointmentRules()),
            1 => $this->form->validate($this->form->personalInformationRules())
        };
        $this->step += 1;
    }

    public function goToStep($count)
    {
        $this->step = $count;
    }

    public function mount()
    {
        $this->makes = CarDetail::getCarMakes();
        $this->services = Service::cases();
        $this->timeSlots = TimeSlot::getAvailableOptions();
        $this->years = CarDetail::getCarYears();
        $this->form->appointment_date =  Carbon::today()->format('Y-m-d');
    }
    public function render()
    {
        return view('livewire.appointment.create');
    }

    public function getAvailableTime()
    {
        $this->timeSlots = TimeSlot::getAvailableOptions($this->form->appointment_date);
    }

    public function submit()
    {
        $appointmentDetails = $this->form->store();
        $this->dispatch('appointmentCreated', $appointmentDetails);
    }

    public function setTime($time)
    {
        $this->form->appointment_time = $time;
        $this->appointmentTime = $time;
    }
}
