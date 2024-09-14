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
        'user_id',
        'car_id',
        'service_type',
        'appointment_date',
        'appointment_time',
        'description',
        'additional_notes',
        'is_emergency',
        'to_be_towed'
    ];

    public function getAppointmentTimeAttribute()
    {
        return match ($this->attributes['appointment_time']) {
            '08:00-09:00' => '8:00 am - 9:00 am',
            '09:00-10:00' => '9:00 am - 10:00 am',
            '10:00-11:00' => '10:00 am - 11:00 am',
            '11:00-12:00' => '11:00 am - 12:00 pm',
            '13:00-14:00' => '1:00 pm - 2:00 pm',
            '14:00-15:00' => '2:00 pm - 3:00 pm',
            '15:00-16:00' => '3:00 pm - 4:00 pm',
            '16:00-17:00' => '4:00 pm - 5:00 pm',
        };
    }

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasOne(AppointmentAttachment::class);
    }
}
