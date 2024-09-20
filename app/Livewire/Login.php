<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $username;
    public string $password;

    public function authenticate()
    {
        $credentials = $this->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::guard('customer')->attempt($credentials)) {
            request()->session()->regenerate();
            return redirect('/');
        }

        $this->addError('username', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
