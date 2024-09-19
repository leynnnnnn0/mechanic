<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\CustomerAccount;
use Livewire\Component;

class Register extends Component
{
    public string $email;
    public string $username;
    public string $password;

    public function rules()
    {
        return [
            'email' => 'required',
            'username' => ['required', 'min:3'],
            'password' => ['required', 'min:8']
        ];
    }

    public function store()
    {
        $validated = $this->validate();
        // Check if there is already an existing customer with the given email
        $customer = Customer::where('email', '=', $this->email)->with('account')->first();
        if ($customer) {
            $customer->account()->create([
                'username' => $validated['username'],
                'password' => $validated['password']
            ]);
            $customer->refresh();
        } else {
            $customer = Customer::create([
                'email' => $validated['email']
            ]);
            $customer->account()->create([
                'username' => $validated['username'],
                'password' => $validated['password']
            ]);
            $customer->refresh();
        }
    }

    public function submit()
    {
        $this->store();
    }

    public function render()
    {
        return view('livewire.register');
    }
}
