<?php

namespace App\Livewire;

use App\Models\Appointment;
use Livewire\Component;

class TrackStatus extends Component
{
    public string $query = '';
    public $result;
    public function render()
    {
        return view('livewire.track-status', [
            'result' => $this->result,
        ]);
    }
    public function getResult()
    {
        $this->result = Appointment::where('appointment_number', '=', $this->query)->get();
        $this->result = $this->result[0];
    }
}
