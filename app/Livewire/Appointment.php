<?php

namespace App\Livewire;

use Livewire\Component;

class Appointment extends Component
{
    public string $appointmentNumber;

    public function mount()
    {
        $this->appointmentNumber = 'AN-' . random_int(100000, 999999);
    }
    public function render()
    {
        return view('livewire.appointment');
    }
}
