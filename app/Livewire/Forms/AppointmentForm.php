<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Form;

class AppointmentForm extends Form
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone_number;
    public string $make = 'Honda';
    public string $model = 'Civic';
    public string $year = '2022';
    public string $color = 'Red';
    public string $service_type = '';
    public string $description = '';
    public string $additional_notes = '';
    public bool $is_emergency = false;
    public bool $to_be_towed = false;
    public string $appointment_date = '';
    public string $appointment_time = '';
    public string $status = '';

    public function carRules()
    {
        return [
            'make' => 'required',
            'model' => 'required',
            'year' => 'required',
            'color' => 'required',
        ];
    }

    public function appointmentRules()
    {
        return [
            'service_type' => ['required'],
            'is_emergency' => ['required'],
            'to_be_towed' => ['required'],
            'appointment_date' => ['required'],
            'appointment_time' => ['required']
        ];
    }

    public function personalInformationRules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
        ];
    }

    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'make' => ['required'],
            'model' => ['required'],
            'year' => ['required'],
            'color' => ['required'],
            'service_type' => ['required'],
            'is_emergency' => ['required'],
            'to_be_towed' => ['required'],
            'appointment_date' => ['required'],
            'appointment_time' => ['required']
        ];
    }

    public function store()
    {
        $validated = $this->validate();

        $customer = Customer::updateOrCreate(
            ['email' => $validated['email']],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone_number' => $validated['phone_number'] ?? null,
            ]
        );

        // Create car
        $car = $customer->car()->create([
            'make' => $validated['make'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'color' => $validated['color'],
            'license_plate' => '',
        ]);

        // Create appointment
        $appointment = $car->appointments()->create([
            'appointment_number' => 'AN-' . random_int(100000, 999999),
            'service_type' => $validated['service_type'],
            'description' => $validated['description'] ?? "",
            'additional_notes' => $validated['additional_notes'] ?? "",
            'is_emergency' => $validated['is_emergency'],
            'to_be_towed' => $validated['to_be_towed'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'status' => 'pending',
        ]);

        $appointment['vehicle'] = $car->carDetails;

        return $appointment;
    }
}
