<?php

namespace App\Livewire\Appointment;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Map extends Component
{
    public $apiKey;
    public $mapUrl;
    public $mechanicAddress;
    public $from;
    public $address;

    public function submit()
    {
        $url = "https://api.geoapify.com/v1/geocode/search?text=$this->address&format=json&apiKey=$this->apiKey";
        $response = Http::get($url);
        $result = $response['results'][0];
        $this->from = [
            'latitude' => $result['lat'],
            'longitude' => $result['lon'],
            'address' => $result['formatted']
        ];

        $this->dispatch('updateMap', $this->from);
    }

    public function mount()
    {
        $this->apiKey = env('GEOAPIFY_API_KEY');
        $this->mechanicAddress = [
            'latitude' => 14.403519,
            'longitude' => 120.880015,
            'address' => 'Lavanya Square, 4107 Cavite, Philippines'
        ];
        $this->from = [
            'latitude' => 14.403519,
            'longitude' => 120.880015,
            'address' => 'Lavanya Square, 4107 Cavite, Philippines'
        ];
    }

    public function render()
    {
        return view('livewire.appointment.map');
    }
}
