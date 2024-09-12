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
        'date_and_time',
        'description',
        'additional_notes',
        'is_emergency',
        'to_be_towed'
    ];

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
