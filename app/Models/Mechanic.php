<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mechanic extends Authenticatable implements HasName
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'specialization',
        'street_address',
        'city',
        'barangay',
        'state_or_province',
        'postal_code',
        'email',
        'phone_number',
        'password'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function cars()
    {
        return $this->hasManyThrough(Car::class, ServiceJob::class);
    }


    public function serviceJobs()
    {
        return $this->hasMany(ServiceJob::class);
    }

    public function getFilamentName(): string
    {
        return "{$this->username}";
    }
}
