<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'appointment_number',
        'car_id',
        'service_type',
        'appointment_date',
        'appointment_time',
        'description',
        'additional_notes',
        'is_emergency',
        'to_be_towed',
        'status'
    ];

    public function getDescriptionAttribute()
    {
        return $this->description ?? 'None';
    }

    public function getAdditionalNotesAttribute()
    {
        return $this->additional_notes ?? 'None';
    }
    public function getEmergencyAttribute()
    {
        return $this->is_emergency ? 'Yes' : 'No';
    }

    public function getTowedAttribute()
    {
        return $this->to_be_towed ? 'Yes' : 'No';
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function attachments()
    {
        return $this->hasMany(AppointmentAttachment::class);
    }
}
