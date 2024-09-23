<?php

namespace App\Livewire;

use App\Models\Appointment;
use Livewire\Component;

class TrackStatus extends Component
{
    public string $query = '';
    public  $result;

    public function render()
    {
        return view('livewire.track-status');
    }
    public function getResult()
    {
        $result = Appointment::where('appointment_number', '=', $this->query)->first();
        if (!$result) return;
        $this->result = $this->result[0];
    }
}
