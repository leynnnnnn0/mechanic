<?php

namespace App\Livewire;

use App\Enum\Service;
use App\Enum\TimeSlot;
use App\Http\Controllers\Api\CarDetail;
use Livewire\Component; 

class Appointment extends Component
{
    public function render()
    {
        return view('livewire.appointment');
    }
}
