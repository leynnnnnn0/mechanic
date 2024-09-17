<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'make',
        'model',
        'year',
        'license_plate',
        'color',
    ];

    public function getCarDetailsAttribute()
    {
        return "$this->make $this->model $this->year";
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function serviceJob()
    {
        return $this->hasMany(ServiceJob::class);
    }
}
