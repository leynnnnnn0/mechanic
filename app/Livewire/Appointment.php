<?php

namespace App\Livewire;

use App\Enum\Service;
use App\Http\Controllers\Api\CarDetail;
use Livewire\Component;

class Appointment extends Component
{
    public string $appointmentNumber;
    public array $makes;
    public array $services;
    public function mount()
    {
        $this->appointmentNumber = 'AN-' . random_int(100000, 999999);
        $this->makes = CarDetail::getCarMakes();
        $this->services = Service::cases();
    }
    public function render()
    {
        return view('livewire.appointment');
    }
}
