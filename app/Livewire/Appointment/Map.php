<?php

namespace App\Livewire\Appointment;

use Exception;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class Map extends Component
{
    public $formData;
    public $apiKey;
    public $mapUrl;
    public $mechanicAddress;
    public $from;
    public $address;

    public function mount($form)
    {
        $this->formData = $form;
        $this->apiKey = env('GEOAPIFY_API_KEY');
        $this->mechanicAddress = [
            'latitude' => 14.403519,
            'longitude' => 120.880015,
            'address' => 'Mechanic Place, 4107 Cavite, Philippines'
        ];
        $this->from = [
            'latitude' => 14.403519,
            'longitude' => 120.880015,
            'address' => 'Lavanya Square, 4107 Cavite, Philippines'
        ];
    }
    #[On('updateMap')]
    public function getDistance($form)
    {
        $this->address = $form['street_address'] . ' ' . $form['barangay'] . ' ' . $form['city'] . ' ' . $form['state_or_province'] . ' ' .  $form['postal_code'];
        $url = "https://api.geoapify.com/v1/geocode/search?text=$this->address&format=json&apiKey=$this->apiKey";
        try {
            $response = Http::get($url);
            $result = $response['results'][0];
            $this->from = [
                'latitude' => $result['lat'],
                'longitude' => $result['lon'],
                'address' => $result['formatted']
            ];
        } catch (Exception $e) {
            $this->from = [
                'latitude' => 14.403519,
                'longitude' => 120.880015,
                'address' => 'Lavanya Square, 4107 Cavite, Philippines'
            ];
        }
        $this->dispatch('locationLoaded', $this->from);
    }

    public function render()
    {
        return view('livewire.appointment.map');
    }
}
