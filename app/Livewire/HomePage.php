<?php

namespace App\Livewire;

use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page');
    }

    public function acknowledge()
    {
        request()->session()->put('acknowledged', true);
    }
}
